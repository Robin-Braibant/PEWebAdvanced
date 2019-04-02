<?php
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 26/03/19
 * Time: 11:54
 */

namespace Restaurant\data;


class ConnectionFactory
{
    private $database = "mysql";
    private $databaseName = "Restaurants";
    private $host = "localhost";
    private $username = "root";
    private $password = "root";

    public function getConnection() {
        $connection = new PDO("$this->database:dbname=$this->databaseName;host=$this->host;",
            $this->username, $this->password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }
}