<?php

class DB {
    private $connection;

    public function __construct()
    {
        $connection = $_ENV["DB_CONNECTION"];
        $host = $_ENV["DB_HOST"];
        $port = $_ENV["DB_PORT"];
        $username = $_ENV["DB_USERNAME"];
        $database_name = $_ENV["DB_DATABASE"];
        $password = $_ENV["DB_PASSWORD"];

        $this->connection = new PDO("$connection:host=$host:$port;dbname=$database_name", $username, $password, [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
    }

    public function getConnection()
    {
        return $this->connection;
    }
}