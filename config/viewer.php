<?php

return [
    'types' => [
        'ensemble' => [
            'title' => 'Ensemble',
            'model' => 'MongoModel',
            'view' => 'viewers.ensemble',
            'options' => [
                'database' => 'testdb',
            ]
        ],
        'dbsnp' => [
            'title' => 'dbSNP',
            'model' => 'MongoModel',
            'view' => 'viewers.dbsnp',
            'options' => [
                'database' => 'testdb',
            ]
        ],
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