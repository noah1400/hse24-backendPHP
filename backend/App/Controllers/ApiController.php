<?php

namespace App\Controllers;
use Core\Response;
use Core\App;

use function Core\abort;
use function Core\request;

class ApiController
{
    public function sayHello($request)
    {
        Response::json([
            'message' => 'Hello World',
        ]);
    }

    public function greetByName($request, $name)
    {
        Response::json([
            'message' => 'Hello ' . $name,
        ]);
    }
}
