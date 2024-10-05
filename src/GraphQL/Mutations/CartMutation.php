<?php
namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use PDO;
use PDOException;

class CartMutation extends ObjectType
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $config = [
            'name' => 'CartMutation',
            'fields' => $this->getFields(),
        ];

        parent::__construct($config);
    }

    public function getFields():array{
        return [
            'addCartItem'=>[
                'type'=>Type::int(),
                'args'=>[
                    'product_id'=>['type'=>Type::nonNull(Type::string())],
                    'product'=>['type'=>Type::nonNull(Type::string())],
                    'quantity'=>['type'=>Type::nonNull(Type::int())],
                    'amount'=>['type'=>Type::nonNull(Type::float())],
                    'attributes' => Type::listOf(Type::string()),

                ],
                'resolve'=>function($root,$args){
                    return $this->addCartItems($args['product'],$args['quantity'],$args['amount'],$args['product_id'],$args['attributes']);
                }
            ]
        ];
    }

    protected function addCartItems($product,$quantity,$amount,$product_id,$attributes): false|string
    {
        $stmt = $this->pdo->prepare("INSERT INTO cart (product_id, product, amount, quantity) VALUES (?, ?, ?, ?)");
        $stmt->execute([$product_id, $product, $amount, $quantity]);
        $cart_id = $this->pdo->lastInsertId();


        foreach ($attributes as $attribute_name => $product_value) {
            $stmt = $this->pdo->prepare("INSERT INTO cart_attributes (cart_id, attribute_name, product_value) VALUES (?, ?, ?)");
            $stmt->execute([$cart_id, $attribute_name, $product_value]);
        }

        return $cart_id;
    }
}