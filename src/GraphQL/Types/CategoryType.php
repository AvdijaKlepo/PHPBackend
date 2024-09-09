<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CategoryType extends ObjectType{

    function __construct()
    {
        $categoryType = [
            'name' => 'Category',
            'fields' => [
                'id'=>Type::string(),
                'category'=>Type::string(),
            ]
        ];

        return parent::__construct($categoryType);
    }
}