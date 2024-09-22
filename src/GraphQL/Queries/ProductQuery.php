<?php

namespace App\GraphQL\Queries;
use App\GraphQL\Types\ProductType;
use App\Models\AbstractModels\AbstractProduct;
use App\Models\Factory\ProductFactory;
use App\Service\ProductService;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use PDO;


class ProductQuery extends ObjectType
{
    protected PDO $pdo;
    protected ProductService $productService;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->productService = new ProductService($pdo);


        $config = [
            'name' => 'ProductQuery',
            'fields' => $this->getFields(),
        ];

        parent::__construct($config);

    }

    public function getFields(): array
    {
        return [
            'products' => [
                'type'=>Type::listOf(new ProductType($this->pdo,$this->productService)),
                'args' => [
                    'category_id'=>['type'=>Type::int()],
                    'id'=>['type'=>(Type::string())],
                ],

                'resolve' => function ($root, $args) {
                    $productId = $args['id'] ?? null;

                    if ($productId) {
                        $product = (new ProductFactory)->getProductById($this->pdo, $productId);
                        return $product ? [$product] : null;
                    }

                    if (!isset($args['category_id']) || !is_int($args['category_id'])) {
                        throw new \Exception('category_id must be an integer');
                    }

                    $category_id = $args['category_id'];
                    $product = ProductFactory::create($this->pdo, $category_id);
                    error_log('category_id: ' . print_r($args['category_id'], true));
                    return $product->getProduct();
                }

            ]
        ];

    }


}


