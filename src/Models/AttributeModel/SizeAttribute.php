<?php
namespace App\Models\AttributeModel;

use App\Models\AbstractModels\AbstractAttribute;
use PDO;

class SizeAttribute extends AbstractAttribute{

    public function getAttribute(): array
    {
        $sizeIdentifier = "Size";
        $query = "SELECT * FROM attributes AS A
                    JOIN attributes_items AS AI
                    ON A.id=AI.attribute_id
                    WHERE attribute_name='Size'";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}