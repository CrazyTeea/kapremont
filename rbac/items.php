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
            '/app/organization/*',
            '/app/program/index',
        ],
    ],
    'orglist_view' => [
        'type' => 2,
        'children' => [
            '/app/organization/list',
            '/app/mgsu-admin/main-table',
            '/app/mgsu-admin/view',
            '/app/mgsu-admin/count',
        ],
    ],
    '/app/organization/list' => [
        'type' => 2,
    ],
    '/app/organization/*' => [
        'type' => 2,
    ],
    '/app/program/index' => [
        'type' => 2,
    ],
    '/app/mgsu-admin/view' => [
        'type' => 2,
    ],
    '/app/mgsu-admin/main-table' => [
        'type' => 2,
    ],
    '/app/mgsu-admin/count' => [
        'type' => 2,
    ],
];
