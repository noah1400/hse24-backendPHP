<?php

namespace App\Controllers;
use Core\Response;
use Core\App;

use function Core\abort;
use function Core\request;

class ShoppingController
{

    public function getAllItems($request)
    {
        $db = App::resolve('Core\Database\Database');
        $items = $db->select('shopping_items');
        Response::json($items);
    }

    public function addItem($request)
    {
        // Since the frontend sends the data as JSON (Content-Type: application/json),
        // and not as form data the PHP superglobal $_POST is empty.
        // We need to read the raw post data and decode it.
        $rawData = file_get_contents('php://input'); // raw post data
        $data = json_decode($rawData, true);

        if (!isset($data['name']) || !isset($data['amount'])) {
            // If the request was send via a different tool like Postman
            // and the data was sent as form data, we can use the request() function
            $name = request('name');
            $amount = request('amount');
            if (!$name || !$amount) {
                abort(400, 'Invalid data'); // Bad request
            }
        } else {
            $name = $data['name'];
            $amount = $data['amount'];
        }

        $db = App::resolve('Core\Database\Database');

        // check if item already exists
        $item = $db->select('shopping_items', ['name' => $name]);

        if (!empty($item)) {
            $item = $item[0];
            $id = $item['id'];
            $newAmount = $item['amount'] + $amount;
            $db->query('UPDATE shopping_items SET amount = :amount WHERE id = :id', [
                'id' => $id,
                'amount' => $newAmount,
            ]);
        } else {

            $db->query('INSERT INTO shopping_items (name, amount) VALUES (:name, :amount)', [
                'name' => $name,
                'amount' => $amount,
            ]);
        }

        // get added item
        $lastId = $db->lastInsertId();
        $item = $db->select('shopping_items', ['id' => $lastId]);
        Response::json($item, 201);
    }

    public function getItemByName($request, $name)
    {
        $db = App::resolve('Core\Database\Database');
        $item = $db->select('shopping_items', ['name' => $name]);
        if (empty($item)) {
            abort(404, 'Item not found');
        }
        Response::json($item);
    }

    public function updateItem($request, $name)
    {
        // Since the frontend sends the data as JSON (Content-Type: application/json),
        // and not as form data the PHP superglobal $_POST is empty.
        // We need to read the raw post data and decode it.
        $rawData = file_get_contents('php://input'); // raw post data
        $data = json_decode($rawData, true);

        if (!isset($data['amount'])) {
            // If the request was send via a different tool like Postman
            // and the data was sent as form data, we can use the request() function
            $amount = request('amount');
            if (!$amount) {
                abort(400, 'Invalid data'); // Bad request
            }
        } else {
            $amount = $data['amount'];
        }

        $db = App::resolve('Core\Database\Database');
        $db->query('UPDATE shopping_items SET amount = :amount WHERE name = :name', [
            'name' => $name,
            'amount' => $amount,
        ]);

        // get updated item
        $item = $db->select('shopping_items', ['name' => $name]);
        Response::json($item);
    }

    public function deleteItem($request, $name)
    {
        $db = App::resolve('Core\Database\Database');
        $db->query('DELETE FROM shopping_items WHERE name = :name', [
            'name' => $name,
        ]);
        Response::json([], 204);
    }
}
