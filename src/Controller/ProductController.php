<?php

namespace App\Controller;
use App\GraphQL\Mutations\CartMutation;
use App\GraphQL\Queries\CategoryQuery;
use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;
use App\GraphQL\Queries\ProductQuery;

class ProductController
{
    public static function handleGraphQL($vars, $conn): false|string
    {
        $productQuery = new ProductQuery($conn);
        $categoryQuery = new CategoryQuery($conn);
        $cartMutation = new CartMutation($conn);

        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => array_merge(
                $productQuery->getFields(),
                $categoryQuery->getFields()
            ),
        ]);

        $mutationType = new ObjectType([
            'name' => 'Mutation',
            'fields' => $cartMutation->getFields(),
        ]);

        $schema = new Schema([
            'query' => $queryType,
            'mutation' => $mutationType,
        ]);


        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);
        $query = $input['query'];
        $variables = $input['variables'] ?? null;


        $result = GraphQL::executeQuery($schema, $query, null, null, $variables);
        $output = $result->toArray();

        header('Content-Type: application/json');
        return json_encode($output);
    }
}

