<?php

$connection = $_ENV["DB_CONNECTION"];
$host = $_ENV["DB_HOST"];
$port = $_ENV["DB_PORT"];
$username = $_ENV["DB_USERNAME"];
$database_name = $_ENV["DB_DATABASE"];
$password = $_ENV["DB_PASSWORD"];

$db = new PDO("$connection:host=$host:$port;dbname=$database_name", $username, $password);

var_dump($db);
