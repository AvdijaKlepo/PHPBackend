<?php

namespace App\Models\ConcreteModel;


use App\Models\AbstractModels\AbstractProduct;
use PDO;

class ClothesProduct extends AbstractProduct
{
    public function getProduct(): array
    {
        $query = "SELECT * FROM products WHERE category_id = 2";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}