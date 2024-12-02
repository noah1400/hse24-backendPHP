<?php

namespace Routes;

use Core\Router;

require 'errors.php';

Router::get('/shopping', 'ShoppingController@getAllItems');
Router::post('/shopping', 'ShoppingController@addItem');
Router::get('/shopping/{name}', 'ShoppingController@getItemByName');
Router::put('/shopping/{name}', 'ShoppingController@updateItem');
Router::delete('/shopping/{name}', 'ShoppingController@deleteItem');

// Hello World Routes
Router::get('/hello', 'ApiController@sayHello');
Router::get('/hello/{name}', 'ApiController@greetByName');