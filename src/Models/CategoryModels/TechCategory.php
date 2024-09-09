<?php

namespace App\Models\CategoryModels;

use App\Models\AbstractModels\AbstractCategory;
use PDO;

class TechCategory extends AbstractCategory{

    public function getCategory(): array
    {
        $query = "SELECT * FROM categories WHERE id=3";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}