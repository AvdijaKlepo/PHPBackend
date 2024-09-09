<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class GalleryType extends ObjectType{
    function __construct()
    {
        $galleryType=[
            'name' => 'Gallery',
            'fields' => [
                'id'=>Type::int(),
                'product_id'=>Type::string(),
                'image'=>Type::string(),
            ]
        ];

        return parent::__construct($galleryType);
    }
}