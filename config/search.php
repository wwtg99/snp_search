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
                return array_get($data, 'name', '');
            },
            'abstract' => function ($data) {
                return implode(' ', [array_get($data, 'gene', ''), array_get($data, 'allele_origin', ''), array_get($data, 'clinical_significance', '')]);
            },
            'link' => function ($data) {
                if (isset($data['name'])) {
                    return ['name' => 'dbSNP', 'link'=>'https://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=' . $data['name']];
                } else {
                    return null;
                }
            },
            'viewable' => null,
        ],
        'ensemble' => [
            'label' => 'Ensemble',
            'title' => function ($data) {
                return array_get($data, 'name', '');
            },
            'abstract' => function ($data) {
                return implode('', [array_get($data, 'ancestral_allele', ''), '/', array_get($data, 'minor_allele', '')]);
            },
            'link' => function ($data) {
                if (isset($data['name'])) {
                    return ['name' => 'Ensemble', 'link' => 'http://www.ensembl.org/Homo_sapiens/Variation/Explore?db=core;v=' . $data['name'] . ';vdb=variation'];
                } else {
                    return null;
                }
            },
            'viewable' => null
        ],
        'deafnessvdb' => [
            'label' => 'DeafnessVariant',
            'title' => function ($data) {
                return array_get($data, 'variation', '');
            },
            'abstract' => function ($data) {
                return implode(' ', ['<b>', array_get($data, 'dbsnp', ''), '</b>', '<i>', array_get($data, 'gene', ''), '</i>', '<br>', array_get($data, 'pathogenicity', '')]);
            }
        ],
        'pharmgkb' => [
            'label' => 'PharmGKB',
            'title' => function ($data) {
                return array_get($data, 'name');
            },
            'abstract' => function ($data) {
                return implode(' ', [array_get($data, 'accessionId', ''), '<i>', array_get($data, 'gene', ''), '</i>', '<b>(Level ' . array_get($data, 'levelOfEvidence.term', '') . ')</b>', '<br>', array_get($data, 'loci', '')]);
            }
        ],
        'gwas_catelog' => [
            'label' => 'GWAS Catelog',
            'title' => function ($data) {
                return $data['snp_risk'];
            },
            'abstract' => function ($data) {
                return "${data['region']} <b>${data['trait']}</b> p-value ${data['pvalue']} PMID ${data['pmid']}";
            }
        ],
    ]
];