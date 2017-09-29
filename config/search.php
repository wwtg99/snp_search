<?php

return [
    'types' => [
//        'dbsnp' => [  //type
//            'label' => 'dbSNP',  //type label
//            'title' => function ($data) {  //title handler
//                return $data['name'];
//            },
//            'abstract' => function ($data) {  //abstract handler
//                return implode(' ', [$data['gene'], isset($data['allele_origin']) ? $data['allele_origin'] : '', isset($data['clinical_significance']) ? $data['clinical_significance'] : '']);
//            },
//            'link' => null,  //outter link
//            'viewable' => null,  //fields to view on frontend
//        ],
        'dbsnp' => [
            'label' => 'dbSNP',
            'title' => function ($data) {
                return $data['name'];
            },
            'abstract' => function ($data) {
                return implode(' ', [$data['gene'], isset($data['allele_origin']) ? $data['allele_origin'] : '', isset($data['clinical_significance']) ? $data['clinical_significance'] : '']);
            },
            'link' => null,
            'viewable' => null,
        ],
        'ensemble' => [
            'label' => 'Ensemble',
            'title' => function ($data) {
                return $data['name'];
            },
            'abstract' => function ($data) {
                return implode('',[$data['ancestral_allele'], '/', $data['minor_allele']]);
            }
        ]
    ]
];