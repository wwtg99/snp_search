<?php

return [
    'types' => [
        'ensemble' => [
            'title' => 'Ensemble',
            'model' => 'MongoModel',
            'view' => 'viewers.ensemble',
        ],
        'dbsnp' => [
            'title' => 'dbSNP',
            'model' => 'MongoModel',
            'view' => 'viewers.dbsnp',
        ],
        'pharmgkb' => [
            'title' => 'PharmGKB',
            'model' => 'MongoModel',
            'view' => 'viewers.pharmgkb',
        ],
    ],
];