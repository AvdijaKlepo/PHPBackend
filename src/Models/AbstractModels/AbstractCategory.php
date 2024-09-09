<?php
namespace App\Models\AbstractModels;

use App\Models\CategoryModels\AllCategory;
use App\Models\CategoryModels\ClothesCategory;
use App\Models\CategoryModels\TechCategory;
use PDO;

abstract class AbstractCategory{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    abstract public function getCategory():array;

    public static function create(PDO $pdo,int $id): AbstractCategory
    {
        switch ($id){
            case 1:
                return new ClothesCategory($pdo);
            case 2:
                return new TechCategory($pdo);
            default:
                return new AllCategory($pdo);
        }
    }

}