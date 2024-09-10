<?php
namespace App\Models\Factory;

use App\Models\AbstractModels\AbstractAttribute;
use App\Models\AttributeModel\TechAttributes;
use App\Models\AttributeModel\ClothesAttributes;
use PDO;

class AttributeFactory
{
    public static function create(PDO $pdo,int $categoryId):AbstractAttribute
    {
        return match($categoryId) {
             3 => new TechAttributes($pdo),
             2 => new ClothesAttributes($pdo),
        };
    }
}