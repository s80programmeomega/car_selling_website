<?php

return [
    'api_key' => env('TYPESENSE_API_KEY', ''),
    'nodes' => [
        [
            'host' => env('TYPESENSE_HOST', 'localhost'),
            'port' => env('TYPESENSE_PORT', '8108'),
            'protocol' => env('TYPESENSE_PROTOCOL', 'http'),
        ],
    ],
    'connection_timeout_seconds' => 2,
    'model-settings' => [
        \App\Models\Car::class => [
            'collection-schema' => [
                'fields' => [
                    ['name' => 'id', 'type' => 'int32'],
                    ['name' => 'maker', 'type' => 'string', 'facet' => true],
                    ['name' => 'model', 'type' => 'string', 'facet' => true],
                    ['name' => 'year', 'type' => 'int32', 'facet' => true],
                    ['name' => 'price', 'type' => 'float', 'facet' => true],
                    ['name' => 'mileage', 'type' => 'int32'],
                    ['name' => 'description', 'type' => 'string'],
                    ['name' => 'transmission', 'type' => 'string', 'facet' => true],
                    ['name' => 'color', 'type' => 'string', 'facet' => true],
                    ['name' => 'fuel_type', 'type' => 'string', 'facet' => true],
                    ['name' => 'car_type', 'type' => 'string', 'facet' => true],
                    ['name' => 'city', 'type' => 'string', 'facet' => true],
                    ['name' => 'state', 'type' => 'string', 'facet' => true],
                    ['name' => 'published', 'type' => 'bool'],
                    ['name' => 'featured', 'type' => 'bool'],
                    ['name' => 'condition', 'type' => 'string', 'facet' => true],
                ],
                'default_sorting_field' => 'year',
            ],
            'search-parameters' => [
                'query_by' => 'maker,model,description,color,transmission,fuel_type,car_type,city,state',
            ],
        ],
    ],
];
