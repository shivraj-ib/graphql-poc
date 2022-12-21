<?php

namespace IB;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;

class getApi
{
    public function test()
    {
        $street = new ObjectType([
            'name' => 'Street',
            'description' => 'Customer Address from json object',
            'fields' => [
                'street1' => Type::string(),
                'street2' => Type::string(),
            ]
        ]);

        $address = new ObjectType([
            'name' => 'Address',
            'description' => 'Customer Address from json object',
            'fields' => [
                'addressId' => Type::int(),
                'state' => Type::string(),
                'city' => Type::string(),
                'street' => [
                    "type" => $street,
                    'resolve' => function ($root, $args, $context) {
                        return $root['street'];
                    }
                ],
                'country' => Type::string()
            ]
        ]);

        $userType = new ObjectType([
            'name' => 'Customer',
            'description' => 'Customer from json object',
            'fields' => [
                'id' => Type::int(),
                'firstname' => Type::string(),
                'lastname' => Type::string(),
                'age' => Type::int(),
                'address' => [
                    "type" => $address,
                    'resolve' => function ($root, $args, $context) {
                        return $root['address'];
                    }
                ]
            ]
        ]);

        try {
            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'customer' => [
                        'type' => $userType,
                        'args' => [
                            'id' => Type::int(),
                        ],
                        'resolve' => function ($root, $args) {
                            $returnArray = [];
                            foreach ($root as $key => $customer) {
                                if ($customer["id"] == $args["id"])
                                    $returnArray = $customer;
                            }
                            return $returnArray;
                        }
                    ],
                ],
            ]);


            $schema = new Schema([
                "query" => $queryType
            ]);

            $rawInput = file_get_contents('php://input');
            $input = json_decode($rawInput, true);
            $query = $input['query'];

            $variableValues = isset($input['variables']) ? $input['variables'] : null;
            $variableValues = [];
            $rootValue = $this->rootValue();
            $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);

            $output = $result->toArray();
        } catch (\Exception $e) {
            $output = [
                'error' => [
                    'message' => $e->getMessage()
                ]
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($output);
    }

    //Dummy data
    public function rootValue()
    {
        return [
            [
                "id" => 1,
                "firstname" => "John",
                "lastname" => "Doe",
                "age" => 14,
                "address" =>
                [
                    "addressId" => 1,
                    "street" => ["street1" => "167", "street2" => "XX Floor"],
                    "city" => "New York",
                    "state" => "NY",
                    "country" => "USA"
                ]
            ],
            [
                "id" => 2,
                "firstname" => "chris",
                "lastname" => "Martin",
                "age" => 29,
                "address" => [
                    "addressId" => 2,
                    "street" => ["street1" => "167", "street2" => "XX Floor"],
                    "city" => "New York",
                    "state" => "NY",
                    "country" => "USA"
                ]
            ],
            [
                "id" => 3,
                "firstname" => "Jenny",
                "lastname" => "Ketty",
                "age" => 32,
                "address" => [
                    "addressId" => 3,
                    "street" => ["street1" => "167", "street2" => "XX Floor"],
                    "city" => "New York",
                    "state" => "NY",
                    "country" => "USA"
                ]
            ],
            [
                "id" => 4,
                "firstname" => "Jennifer",
                "lastname" => "Tim",
                "age" => 31,
                "address" => [
                    "addressId" => 4,
                    "street" => ["street1" => "167", "street2" => "XX Floor"],
                    "city" => "New York",
                    "state" => "NY",
                    "country" => "USA"
                ]
            ]
        ];
    }
}
