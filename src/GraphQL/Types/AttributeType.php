<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeType extends ObjectType{

    function __construct()
    {
        $attributeType=[
            'name' => 'Attribute',
            'fields' => [
                'id'=>Type::string(),
                'attribute_name'=>Type::string(),
                'attribute_type'=>Type::string(),
                'product_id'=>Type::string(),
                'display_value'=>Type::string(),
                'product_value'=>Type::string(),
            ]
        ];

        return parent::__construct($attributeType);
    }
}