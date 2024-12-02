<?php

namespace App\Controllers;
use Core\Response;
use Core\App;

use function Core\abort;
use function Core\request;

class ShoppingController
{
    public function index($request)
    {
        $db = App::resolve('Core\Database\Database');
        Response::view('notes.index', [
            'name' => request('name','John Doe'),
        ]);
    }

    public function getAllItems($request)
    {
        $db = App::resolve('Core\Database\Database');
        $items = $db->select('shopping_items');
        Response::json($items);
    }

    public function addItem($request)
    {
        $rawData = file_get_contents('php://input'); // raw post data
        $data = json_decode($rawData, true);
        $name = $data['name'];
        $amount = $data['amount'];

        $db = App::resolve('Core\Database\Database');
        $db->query('INSERT INTO shopping_items (name, amount) VALUES (:name, :amount)', [
            'name' => $name,
            'amount' => $amount,
        ]);

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
        $rawData = file_get_contents('php://input'); // raw post data
        $data = json_decode($rawData, true);
        $amount = $data['amount'];

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
