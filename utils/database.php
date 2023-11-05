<?php

require_once '../config/config.php';

class Database
{
    private $connection;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
        mysqli_select_db($this->connection, DB_NAME);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
