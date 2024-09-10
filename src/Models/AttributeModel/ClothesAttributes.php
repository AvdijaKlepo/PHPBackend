<?php
namespace App\Models\AttributeModel;

use App\Models\AbstractModels\AbstractAttribute;
use PDO;

class ClothesAttributes extends AbstractAttribute{

    public function getAttribute(string $productId): array
    {

        $query = "SELECT A.id,A.attribute_name,A.attribute_type, 
        A.product_id,AI.display_value,AI.product_value 
        FROM attributes AS A
                  JOIN attributes_items AS AI ON A.id = AI.attribute_id
                  JOIN products AS P ON P.id = A.product_id
                  WHERE P.category_id = 2 AND P.id = ?";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$productId]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result ?: [];
        } catch (\PDOException $e) {
            // Log SQL error details
            error_log($e->getMessage());
            return [];
        }
    }
}