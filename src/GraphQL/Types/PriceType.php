<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PriceType extends ObjectType{
    function __construct()
    {
        $priceType=[
            'name' => 'Price',
            'fields' => [
                'id'=>Type::int(),
                'amount'=>Type::float(),
                'label'=>Type::string(),
                'symbol'=>Type::string(),
            ]
        ];
        return parent::__construct($priceType);
    }
}