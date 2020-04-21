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
            '/app/program/export',
            '/app/mgsu-admin/*',
            '/api/com/*',
            '/rest/upload/*',
            '/api/shit/data',
            '/api/user-info/*',
            '/app/program/is-approve',
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
    'faiv_user' => [
        'type' => 1,
        'children' => [
            'dev_program',
            '/*',
            '/api/shit/data',
            '/api/user-info/*',
            '/app/program/is-approve',
        ],
    ],
    'faiv_admin' => [
        'type' => 1,
        'children' => [
            '/faiv/faiv/admin-view',
            '/faiv/faiv/user-view',
            '/faiv/faiv/user-create-view',
            '/*',
            'dev_program',
            '/api/com/*',
            '/rest/upload/*',
            '/api/shit/data',
            '/api/user-info/*',
            '/app/program-objects/create',
        ],
    ],
    '/app/program/export' => [
        'type' => 2,
    ],
    '/faiv/faiv/user-view' => [
        'type' => 2,
    ],
    '/faiv/faiv/user-create-view' => [
        'type' => 2,
    ],
    '/faiv/faiv/admin-view' => [
        'type' => 2,
    ],
    '/app/development-programme/check-doc' => [
        'type' => 2,
    ],
    '/app/program/is-approve' => [
        'type' => 2,
    ],
    '/app/program-objects/create' => [
        'type' => 2,
    ],
    '/app/mgsu-admin/*' => [
        'type' => 2,
    ],
    'dep' => [
        'type' => 1,
        'children' => [
            'orglist_view',
            '/app/organization/*',
            '/api/comment/*',
            '/app/program/index',
            '/app/program-objects/download-doc',
            '/app/development-programme/download-doc',
            '/app/program-objects/zip',
            '/app/program-objects/export',
            '/app/program/export',
            '/app/mgsu-admin/*',
            '/api/com/*',
            '/rest/upload/*',
            '/api/user-info/*',
            '/app/program/is-approve',
        ],
    ],
    'dku' => [
        'type' => 1,
        'children' => [
            'orglist_view',
            '/app/organization/*',
            '/app/program/index',
            '/app/program-objects/download-doc',
            '/app/development-programme/download-doc',
            '/api/comment/*',
            '/app/program-objects/export',
            '/app/program/export',
            '/app/program-objects/zip',
            '/app/mgsu-admin/*',
            '/api/com/*',
            '/rest/upload/*',
            '/app/program/is-approve',
        ],
    ],
    '/api/com/*' => [
        'type' => 2,
    ],
    '/rest/upload/*' => [
        'type' => 2,
    ],
    '/api/shit/data' => [
        'type' => 2,
    ],
    '/api/user-info/*' => [
        'type' => 2,
    ],
];
