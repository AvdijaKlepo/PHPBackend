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
        $this->productService = $productService;

        $config = [
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
                    'resolve' => [$this, 'resolveAttributes'],
                ],
                'images' => [
                    'type' => Type::listOf(new GalleryType()),
                    'resolve' => [$this, 'resolveImages'],
                ],
                'prices' => [
                    'type' => Type::listOf(new PriceType()),
                    'resolve' => [$this, 'resolvePrices'],
                ],
            ],
        ];

        parent::__construct($config);
    }


    public function resolveAttributes($product): ?array
    {
        try {

            $query = "SELECT DISTINCT attribute_name FROM attributes WHERE product_id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$product['id']]);
            $attributeNames = $stmt->fetchAll(PDO::FETCH_COLUMN);

            $attributes = [];
            foreach ($attributeNames as $attributeName) {
                $attributeHandler = AttributeFactory::create($this->pdo, $attributeName);
                $attributes = array_merge($attributes, $attributeHandler->getAttribute($product['id']));
            }

            return !empty($attributes) ? $attributes : null;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }


    public function resolveImages($product): ?array
    {
        return $this->productService->getImagesById($product['id']) ?? null;
    }


    public function resolvePrices($product): ?array
    {
        return $this->productService->getPricesById($product['id']) ?? null;
    }
}
