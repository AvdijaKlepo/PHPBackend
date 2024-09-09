<?php

namespace App\GraphQL\Queries;
use App\GraphQL\Types\ProductType;
use App\Models\AbstractModels\AbstractProduct;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use PDO;


class ProductQuery extends ObjectType
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

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
                'type'=>Type::listOf(new ProductType($this->pdo)),
                'args' => [
                    'category_id'=>['type'=>Type::int()],
                    'id'=>['type'=>Type::string()],
                ],

                'resolve' => function ($root,$args) {
                    $productId=$args['id']??null;

                    if($productId){
                        $product = AbstractProduct::getProductById($this->pdo,$productId);
                        return $product ? [$product] : null;
                    }else


                    $category_id = $args['category_id']?? 3;
                    $product = AbstractProduct::create($this->pdo,$category_id);
                    return $product->getProduct();

                }
            ]
        ];

    }


}


