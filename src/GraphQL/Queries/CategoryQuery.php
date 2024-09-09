<?php

namespace App\GraphQL\Queries;


use App\GraphQL\Types\CategoryType;
use App\Models\AbstractModels\AbstractCategory;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use PDO;


class CategoryQuery extends ObjectType{
    protected PDO $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo=$pdo;

        $config = [
            'name' => 'CategoryQuery',
            'fields' => $this->getFields(),
            ];

        parent::__construct($config);
    }

    public function getFields(): array
    {
        return [
            'categories'=>[
                'type'=>Type::listOf(new CategoryType),
                'args'=>[
                    'id'=>['type' => Type::int()],
                ],
                'resolve'=>function($root, $args){
                    $id = $args['id']??3;
                    $category = AbstractCategory::create($this->pdo,$id);
                    return $category->getCategory();
                }
            ]
        ];
    }
}