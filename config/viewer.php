<?php

return [
    'types' => [
        'ensemble' => [
            'title' => 'Ensemble',
            'model' => 'MongoModel',
            'view' => 'viewers.ensemble',
            'options' => [
                'database' => 'snp',
            ]
        ],
        'dbsnp' => [
            'title' => 'dbSNP',
            'model' => 'MongoModel',
            'view' => 'viewers.dbsnp',
            'options' => [
                'database' => 'snp',
            ]
        ],
        'pharmgkb' => [
            'title' => 'PharmGKB',
            'model' => 'MongoModel',
            'view' => 'viewers.pharmgkb',
            'options' => [
                'database' => 'gkb',
            ]
        ],
        'deafnessvdb' => [
            'title' => 'Deafness Variant',
            'model' => 'MongoModel',
            'view' => 'viewers.deafnessvdb',
            'options' => [
                'database' => 'snp',
            ]
        ],
    ],
];