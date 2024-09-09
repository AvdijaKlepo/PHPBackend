<?php
namespace App\Models\AttributeModel;


use App\Models\AbstractModels\AbstractAttribute;
use PDO;

class AllAttribute extends AbstractAttribute{
    public function getAttribute(): array
    {
        $capacityIdentifier = "Capacity";
        $query ="SELECT * FROM attributes AS A
                JOIN attributes_items AS AI
                ON A.id=AI.attribute_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}