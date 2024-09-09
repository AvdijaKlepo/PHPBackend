<?php
namespace App\GraphQL\Queries;


use App\GraphQL\Types\AttributeType;
use App\Models\AbstractModels\AbstractAttribute;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use PDO;


class AttributeQuery extends ObjectType
{
        protected PDO $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo=$pdo;

        $config = [
            'name' => 'AttributeQuery',
            'fields' => $this->getFields()
        ];

        parent::__construct($config);
    }

    public function getFields(): array
    {
        return [
            'attributes'=>[
                'type' => Type::listOf(new AttributeType),
                'args'=>[
                    'attribute_name'=>['type'=>Type::int()],
                ],
                'resolve'=>function ($root, $args) {
                    $attributeName=$args['attribute_name']??4;
                    $attribute = AbstractAttribute::create($this->pdo,$attributeName);
                    return $attribute->getAttribute();
                }
            ]
        ];
    }
}