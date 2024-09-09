<?php

namespace App\Database;
use PDO;
use PDOException;

class Database
{
    private mixed $host;
    private mixed $db;
    private mixed $username;
    private mixed $password;
    private $conn;

    public function __construct(array $config)
    {
        $this->host = $config['host'] ?? '';
        $this->db = $config['db_name'] ?? '';
        $this->username = $config['username'] ?? '';
        $this->password = $config['password'] ?? '';
    }

    public function connect():PDO
    {
        if($this->conn == null){
            try {
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                error_log("Connection failed: ".$e->getMessage());
                throw new PDOException("Database Connection Failed");
            }
        }
        return $this->conn;
    }

}