<?php
namespace App\Models\AbstractModels;


use PDO;
abstract class AbstractProduct
{
    protected PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    abstract public function getProduct():array;


}