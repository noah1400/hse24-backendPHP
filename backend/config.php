<?php

use function Core\base_path;

return $config = [
    "app" => [
        "name" => "Shopping API",
    ],
    "db" => [
        "connection" => "mysql",
        "host" => "mysql-db",
        "port" => "3306",
        "name" => "shopping",
        "username" => "shopping",
        "password" => "shopping",
    ],
    "debug" => "false",
    "url" => "http://localhost:80/api"
    ];