<?php
namespace App\GraphQL\Types;



use App\Models\Factory\AttributeFactory;
use App\Service\ProductService;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use PDO;


class ProductType extends ObjectType
{
    protected PDO $pdo;
    protected ProductService $productService;


    public function __construct(PDO $pdo, ProductService $productService)
    {

        $this->pdo = $pdo;
        $this->productService=$productService;
        $createAttribute = function (int $categoryId){
            return AttributeFactory::create($this->pdo, $categoryId);
        };


        $productType = [
            'name' => 'Product',
            'fields' => [
                'id' => (Type::string()),
                'product' => Type::string(),
                'product_description' => Type::string(),
                'inStock' => Type::boolean(),
                'category_id' => Type::int(),
                'brand' => Type::string(),
                'attributes' => [
                    'type' => Type::listOf(new AttributeType()),
                    'resolve' => function ($product) use ($createAttribute)  {
                        try {
                            // Attempt to fetch attributes
                            $attribute = $createAttribute($product['category_id']);
                            $attributes = $attribute->getAttribute($product['id']);

                            return !empty($attributes) ? $attributes : null;
                        } catch (\Exception $e) {
                            // Log the exception (optional) and return null
                            error_log($e->getMessage());
                            return null;
                        }
                    }
                ],
                'images'=>[
                    'type'=>Type::listOf(new GalleryType()),
                    'resolve' => function ($product)  {
                        return $this->resolveFields($product['id'],'getImagesById');
                    }
                ],
                'prices'=>[
                    'type'=>Type::listOf(new PriceType()),
                    'resolve' => function ($product){
                        return $this->resolveFields($product['id'],'getPricesById');

                    }
                ],

            ]
        ];

        parent::__construct($productType);
    }

    private function resolveFields(string $productId,string $method)
    {
        return call_user_func([$this->productService,$method],$productId)??null;
    }
}
