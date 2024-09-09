<?php

namespace App\Controller;
use App\GraphQL\Queries\AttributeQuery;
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
        $attributeQuery = new AttributeQuery($conn);


        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => array_merge(
                $productQuery->getFields(),
                $categoryQuery->getFields()
            ),
        ]);

        // Set up GraphQL schema with the Product query
        $schema = new Schema([
            'query' => $queryType
        ]);


        // Process the GraphQL query
        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);
        $query = $input['query'];

        // Execute the GraphQL query
        $result = GraphQL::executeQuery($schema, $query);
        $output = $result->toArray();

        // Send response
        header('Content-Type: application/json');
        return json_encode($output);
    }
}

