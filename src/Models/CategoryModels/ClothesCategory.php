<?php
namespace App\Models\CategoryModels;

use App\Models\AbstractModels\AbstractCategory;
use PDO;

class ClothesCategory extends AbstractCategory{

    public function getCategory(): array
    {
        $query = "SELECT * FROM categories WHERE id=2";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}