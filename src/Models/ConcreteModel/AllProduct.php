<?php

namespace App\Models\ConcreteModel;


use App\Models\AbstractModels\AbstractProduct;
use PDO;

class AllProduct extends AbstractProduct{

    public function getProduct(): array
    {
        $query = "SELECT * FROM products";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}