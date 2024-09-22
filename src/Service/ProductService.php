<?php
namespace App\Service;

use PDO;

class ProductService {
    protected PDO $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
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