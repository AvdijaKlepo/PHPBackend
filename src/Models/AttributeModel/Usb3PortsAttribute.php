<?php
namespace App\Models\AttributeModel;

use App\Models\AbstractModels\AbstractAttribute;
use PDO;

class Usb3PortsAttribute extends AbstractAttribute
{
    public function getAttribute(string $productId): array
    {
        $query = "
            SELECT A.id, A.attribute_name, A.attribute_type, 
                   A.product_id, AI.display_value, AI.product_value 
            FROM attributes AS A
            JOIN attributes_items AS AI ON A.id = AI.attribute_id
            WHERE A.attribute_name = 'With USB 3 ports' AND A.product_id = ?
        ";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$productId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}

