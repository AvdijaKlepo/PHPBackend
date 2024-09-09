<?php

namespace App\Models\CategoryModels;

use App\Models\AbstractModels\AbstractCategory;
use PDO;

class AllCategory extends AbstractCategory{

    public function getCategory(): array
    {
        $query = "SELECT * FROM categories";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}