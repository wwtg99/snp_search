<?php

return [
    'types' => [
        'pharmgkb' => [
            'title' => 'PharmGKB',
            'model' => 'MongoModel',
            'view' => 'viewers.pharmgkb',
            'options' => [
                'database' => 'testdb',
            ]
        ],
        'deafnessvdb' => [
            'title' => 'Deafness Variant',
            'model' => 'MongoModel',
            'view' => 'viewers.deafnessvdb',
            'options' => [
                'database' => 'testdb',
            ]
        ],
    ],
];