<?php

namespace App\Database;
use PDO;
use PDOException;

class Database
{
    private $conn;

    public function connect():PDO
    {
        if($this->conn == null){
            try {

                $host = $_ENV['DB_HOST'];
                $db = $_ENV['DB_NAME'];
                $username = $_ENV['DB_USERNAME'];
                $password = $_ENV['DB_PASSWORD'];

                $this->conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                error_log("Connection failed: ".$e->getMessage());
                throw new PDOException("Database Connection Failed");
            }
        }
        return $this->conn;
    }

}