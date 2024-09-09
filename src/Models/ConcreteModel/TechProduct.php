<?php

namespace App\Models\ConcreteModel;

use App\Models\AbstractModels\AbstractProduct;
use PDO;

class TechProduct extends AbstractProduct{

    public function getProduct(): array
    {
        $query = "SELECT * FROM products WHERE category_id=3";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}