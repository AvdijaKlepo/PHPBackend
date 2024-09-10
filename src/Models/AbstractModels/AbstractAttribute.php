<?php
namespace App\Models\AbstractModels;


use PDO;

abstract class AbstractAttribute
{
    protected PDO $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo=$pdo;
    }

    abstract public function getAttribute(string $productId):array;


}