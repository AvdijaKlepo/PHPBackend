<?php
namespace App\Models\AbstractModels;

use App\Models\AttributeModel\AllAttribute;
use App\Models\AttributeModel\CapacityAttribute;
use App\Models\AttributeModel\ColorAttribute;
use App\Models\AttributeModel\SizeAttribute;
use PDO;

abstract class AbstractAttribute
{
    protected PDO $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo=$pdo;
    }

    abstract public function getAttribute():array;

    public static function create(PDO $pdo, $attributeName):AbstractAttribute
    {
        switch ($attributeName) {
            case 1:
                return new CapacityAttribute($pdo);
            case 2:
                return new ColorAttribute($pdo);
            case 3:
                return new SizeAttribute($pdo);
            default:
                return new AllAttribute($pdo);
        }
    }
}