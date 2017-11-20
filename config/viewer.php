<?php

return [
    'types' => [
        'pharmgkb' => [
            'title' => 'PharmGKB',
            'model' => 'MongoModel',
            'view' => 'viewers.pharmgkb',
            'options' => [
                'database' => env('MONGO_DATABASE'),  //specify database
                'id_type' => 'string',  //Mongodb id type, object_id for ObjectId, int for integer, default is string
            ]
        ],
        'deafnessvdb' => [
            'title' => 'Deafness Variant',
            'model' => 'MongoModel',
            'view' => 'viewers.deafnessvdb',
            'options' => [
                'database' => env('MONGO_DATABASE'),
            ]
        ],
        'gwas_catelog' => [
            'title' => 'GWAS Catelog',
            'model' => 'MongoModel',
            'view' => 'viewers.gwas_catelog',
            'options' => [
                'database' => env('MONGO_DATABASE'),
                'id_type' => 'object_id'
            ]
        ],
    ],
];