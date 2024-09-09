<?php
namespace App\GraphQL\Types;

use App\Models\AbstractModels\AbstractProduct;
use GraphQL\Examples\Blog\Type\ImageType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use PDO;


class ProductType extends ObjectType
{
    protected PDO $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $productType = [
            'name' => 'Product',
            'fields' => [
                'id' => Type::string(),
                'product' => Type::string(),
                'product_description' => Type::string(),
                'inStock' => Type::boolean(),
                'category_id' => Type::int(),
                'brand' => Type::string(),
                'attributes' => [
                    'type' => Type::listOf(new AttributeType()),
                    'resolve' => function ($product) {

                        $abstractProduct = AbstractProduct::create($this->pdo, $product['category_id']);
                        $attributes = $abstractProduct->getAttributesById($product['id']);

                        return $attributes ?: null;
                    }
                ],
                'images'=>[
                    'type'=>Type::listOf(new GalleryType()),
                    'resolve' => function ($product) {
                        $abstractProduct = AbstractProduct::create($this->pdo, $product['category_id']);
                        $images = $abstractProduct->getImagesById($product['id']);

                        return $images ?: null;
                    }
                ],
                'prices'=>[
                    'type'=>Type::listOf(new PriceType()),
                    'resolve' => function ($product) {
                        $abstractProduct = AbstractProduct::create($this->pdo, $product['category_id']);
                        $prices = $abstractProduct->getPricesById($product['id']);

                        return $prices ?: null;
                    }
                ],

            ]
        ];

        parent::__construct($productType);
    }
}
