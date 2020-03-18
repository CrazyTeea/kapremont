<?php
return [
    'root' => [
        'type' => 1,
        'children' => [
            '/*',
        ],
    ],
    '/*' => [
        'type' => 2,
    ],
    'test' => [
        'type' => 1,
        'children' => [
            '/*',
        ],
    ],
    'dev_program' => [
        'type' => 2,
        'children' => [
            '/app/development-programme/index',
        ],
    ],
    '/app/development-programme/index' => [
        'type' => 2,
    ],
    'mgsu' => [
        'type' => 1,
        'children' => [
            'orglist_view',
            '/*',
        ],
    ],
    'orglist_view' => [
        'type' => 2,
        'children' => [
            '/app/organization/list',
        ],
    ],
    '/app/organization/list' => [
        'type' => 2,
    ],
];
