<?php
namespace App\Models\Factory;

use App\Models\AbstractModels\AbstractProduct;
use App\Models\ConcreteModel\AllProduct;
use App\Models\ConcreteModel\ClothesProduct;
use App\Models\ConcreteModel\TechProduct;
use PDO;

class ProductFactory
{
    protected $pdo;
    public static function create(PDO $pdo,int $categoryId):AbstractProduct
    {

        return match ($categoryId) {
            3=>new TechProduct($pdo),
            2=>new ClothesProduct($pdo),
            1=>new AllProduct($pdo),
        };
    }
    public  function getProductById(PDO $pdo,string $productId): ? array{
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product?:null;
    }

}