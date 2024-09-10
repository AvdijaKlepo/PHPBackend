<?php
namespace App\Models\AbstractModels;


use PDO;

abstract class AbstractCategory{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    abstract public function getCategory():array;



}