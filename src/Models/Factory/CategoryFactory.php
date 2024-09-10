<?php
namespace App\Models\Factory;

use App\Models\AbstractModels\AbstractCategory;
use App\Models\CategoryModels\AllCategory;
use App\Models\CategoryModels\ClothesCategory;
use App\Models\CategoryModels\TechCategory;
use PDO;

class CategoryFactory{
    protected PDO $pdo;
    public static function create(PDO $pdo,int $id): AbstractCategory
    {
        return match ($id) {
            1 => new ClothesCategory($pdo),
            2 => new TechCategory($pdo),
            default => new AllCategory($pdo),
        };
    }
}