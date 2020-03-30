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
            '/app/program-objects/download-doc',
            '/app/development-programme/download-doc',
            '/api/comment/index',
            '/api/comment/view',
            '/api/comment/create',
            '/api/comment/update',
            '/api/comment/delete',
            '/api/comment/options',
            '/api/comment/*',
            '/app/program-objects/zip',
            '/app/program-objects/export',
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
    '/app/program-objects/download-doc' => [
        'type' => 2,
    ],
    '/app/development-programme/download-doc' => [
        'type' => 2,
    ],
    '/api/comment/index' => [
        'type' => 2,
    ],
    '/api/comment/view' => [
        'type' => 2,
    ],
    '/api/comment/create' => [
        'type' => 2,
    ],
    '/api/comment/update' => [
        'type' => 2,
    ],
    '/api/comment/delete' => [
        'type' => 2,
    ],
    '/api/comment/options' => [
        'type' => 2,
    ],
    '/api/comment/*' => [
        'type' => 2,
    ],
    '/app/program-objects/zip' => [
        'type' => 2,
    ],
    '/app/program-objects/export' => [
        'type' => 2,
    ],
];
