<?php
namespace App\Models\AbstractModels;

use App\Models\ConcreteModel\AllProduct;
use App\Models\ConcreteModel\ClothesProduct;
use App\Models\ConcreteModel\TechProduct;
use PDO;
abstract class AbstractProduct
{
    protected PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    abstract public function getProduct():array;


    public static function create(PDO $pdo,int $categoryId): AbstractProduct
    {
        switch ($categoryId) {
            case 1:
                return new TechProduct($pdo);
            case 2:
                return new ClothesProduct($pdo);
            default:
                return new AllProduct($pdo);
        }
    }
    public static function getProductById(PDO $pdo,string $productId): ? array{
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product?:null;
    }


    public function getCategoryById(int $categoryId){
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$categoryId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['category'] ?? null;
    }

    public function getAttributesById(string $productId): false|array
    {
        $stmt =$this->pdo->prepare("SELECT A.id,A.attribute_name,A.attribute_type,A.product_id,AI.display_value,AI.product_value
                                            FROM attributes AS A
                                                     JOIN attributes_items AS AI
                                                          ON A.id=AI.attribute_id
                                            WHERE A.product_id=?");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getImagesById(string $productId): false|array
    {
        $stmt = $this->pdo->prepare("SELECT  G.id,G.product_id,G.image
                                            FROM products AS A
                                                     JOIN gallery AS G
                                                          ON A.id=G.product_id
                                            WHERE G.product_id=?
                                        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getImageById(string $productId): false|array
    {
        $stmt = $this->pdo->prepare("SELECT  G.id,G.product_id,G.image
                                            FROM products AS A
                                                     JOIN gallery AS G
                                                          ON A.id=G.product_id
                                            WHERE G.product_id=?
                                        LIMIT 1");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPricesById(string $productId):false|array{
        $stmt = $this->pdo->prepare("SELECT P.id,P.amount,C.label,C.symbol
                                            FROM prices AS P
                                            JOIN currency AS C
                                            ON P.id=C.prices_id
                                            WHERE P.product_id=?");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}