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
    'user' => [
        'type' => 1,
        'children' => [
            '/app/organization/*',
            '/api/comment/*',
            '/app/mgsu-admin/*',
            '/api/com/*',
            '/api/user-info/*',
            '/rest/upload/*',
            '/debug/*',
            '/site/*',
            '/api/all/*',
            '/api/shit/*',
            '/app/atz/*',
            '/app/app/*',
            '/app/error/*',
            '/app/faiv-admin/*',
            '/app/program/*',
            '/app/program-objects/*',
            '/app/test/*',
            '/rest/cities/*',
            '/rest/program/*',
            '/rest/organizations/*',
            '/rest/system/*',
            '/app/development-programme/*',
            '/rest/program-objects/*',
            '/rest/program-objects/get-status',
            '/app/organization/get-approve-status',
        ],
    ],
    '/admin/assignment/index' => [
        'type' => 2,
    ],
    '/admin/assignment/view' => [
        'type' => 2,
    ],
    '/admin/assignment/assign' => [
        'type' => 2,
    ],
    '/admin/assignment/revoke' => [
        'type' => 2,
    ],
    '/admin/assignment/*' => [
        'type' => 2,
    ],
    '/admin/default/index' => [
        'type' => 2,
    ],
    '/admin/default/*' => [
        'type' => 2,
    ],
    '/admin/menu/index' => [
        'type' => 2,
    ],
    '/admin/menu/view' => [
        'type' => 2,
    ],
    '/admin/menu/create' => [
        'type' => 2,
    ],
    '/admin/menu/update' => [
        'type' => 2,
    ],
    '/admin/menu/delete' => [
        'type' => 2,
    ],
    '/admin/menu/*' => [
        'type' => 2,
    ],
    '/admin/permission/index' => [
        'type' => 2,
    ],
    '/admin/permission/view' => [
        'type' => 2,
    ],
    '/admin/permission/create' => [
        'type' => 2,
    ],
    '/admin/permission/update' => [
        'type' => 2,
    ],
    '/admin/permission/delete' => [
        'type' => 2,
    ],
    '/admin/permission/assign' => [
        'type' => 2,
    ],
    '/admin/permission/remove' => [
        'type' => 2,
    ],
    '/admin/permission/*' => [
        'type' => 2,
    ],
    '/admin/role/index' => [
        'type' => 2,
    ],
    '/admin/role/view' => [
        'type' => 2,
    ],
    '/admin/role/create' => [
        'type' => 2,
    ],
    '/admin/role/update' => [
        'type' => 2,
    ],
    '/admin/role/delete' => [
        'type' => 2,
    ],
    '/admin/role/assign' => [
        'type' => 2,
    ],
    '/admin/role/remove' => [
        'type' => 2,
    ],
    '/admin/role/*' => [
        'type' => 2,
    ],
    '/admin/route/index' => [
        'type' => 2,
    ],
    '/admin/route/create' => [
        'type' => 2,
    ],
    '/admin/route/assign' => [
        'type' => 2,
    ],
    '/admin/route/remove' => [
        'type' => 2,
    ],
    '/admin/route/refresh' => [
        'type' => 2,
    ],
    '/admin/route/*' => [
        'type' => 2,
    ],
    '/admin/rule/index' => [
        'type' => 2,
    ],
    '/admin/rule/view' => [
        'type' => 2,
    ],
    '/admin/rule/create' => [
        'type' => 2,
    ],
    '/admin/rule/update' => [
        'type' => 2,
    ],
    '/admin/rule/delete' => [
        'type' => 2,
    ],
    '/admin/rule/*' => [
        'type' => 2,
    ],
    '/admin/user/index' => [
        'type' => 2,
    ],
    '/admin/user/view' => [
        'type' => 2,
    ],
    '/admin/user/delete' => [
        'type' => 2,
    ],
    '/admin/user/login' => [
        'type' => 2,
    ],
    '/admin/user/logout' => [
        'type' => 2,
    ],
    '/admin/user/signup' => [
        'type' => 2,
    ],
    '/admin/user/request-password-reset' => [
        'type' => 2,
    ],
    '/admin/user/reset-password' => [
        'type' => 2,
    ],
    '/admin/user/change-password' => [
        'type' => 2,
    ],
    '/admin/user/activate' => [
        'type' => 2,
    ],
    '/admin/user/*' => [
        'type' => 2,
    ],
    '/admin/*' => [
        'type' => 2,
    ],
    '/debug/default/db-explain' => [
        'type' => 2,
    ],
    '/debug/default/index' => [
        'type' => 2,
    ],
    '/debug/default/view' => [
        'type' => 2,
    ],
    '/debug/default/toolbar' => [
        'type' => 2,
    ],
    '/debug/default/download-mail' => [
        'type' => 2,
    ],
    '/debug/default/*' => [
        'type' => 2,
    ],
    '/debug/user/set-identity' => [
        'type' => 2,
    ],
    '/debug/user/reset-identity' => [
        'type' => 2,
    ],
    '/debug/user/*' => [
        'type' => 2,
    ],
    '/debug/*' => [
        'type' => 2,
    ],
    '/gii/default/index' => [
        'type' => 2,
    ],
    '/gii/default/view' => [
        'type' => 2,
    ],
    '/gii/default/preview' => [
        'type' => 2,
    ],
    '/gii/default/diff' => [
        'type' => 2,
    ],
    '/gii/default/action' => [
        'type' => 2,
    ],
    '/gii/default/*' => [
        'type' => 2,
    ],
    '/gii/*' => [
        'type' => 2,
    ],
    '/site/error' => [
        'type' => 2,
    ],
    '/site/captcha' => [
        'type' => 2,
    ],
    '/site/user-recover' => [
        'type' => 2,
    ],
    '/site/change-password' => [
        'type' => 2,
    ],
    '/site/index' => [
        'type' => 2,
    ],
    '/site/login' => [
        'type' => 2,
    ],
    '/site/logout' => [
        'type' => 2,
    ],
    '/site/contact' => [
        'type' => 2,
    ],
    '/site/about' => [
        'type' => 2,
    ],
    '/site/kek' => [
        'type' => 2,
    ],
    '/site/*' => [
        'type' => 2,
    ],
    '/api/all/table-list' => [
        'type' => 2,
    ],
    '/api/all/*' => [
        'type' => 2,
    ],
    '/api/com/get-comments' => [
        'type' => 2,
    ],
    '/api/com/save-comment' => [
        'type' => 2,
    ],
    '/api/com/delete-comment' => [
        'type' => 2,
    ],
    '/api/comment/obj' => [
        'type' => 2,
    ],
    '/api/comment/user' => [
        'type' => 2,
    ],
    '/api/shit/*' => [
        'type' => 2,
    ],
    '/api/user-info/roles' => [
        'type' => 2,
    ],
    '/api/user-info/users' => [
        'type' => 2,
    ],
    '/app/app/test' => [
        'type' => 2,
    ],
    '/app/app/*' => [
        'type' => 2,
    ],
    '/app/atz/index' => [
        'type' => 2,
    ],
    '/app/atz/*' => [
        'type' => 2,
    ],
    '/app/development-programme/add-doc' => [
        'type' => 2,
    ],
    '/app/development-programme/delete-doc' => [
        'type' => 2,
    ],
    '/app/development-programme/export' => [
        'type' => 2,
    ],
    '/app/development-programme/status-realize' => [
        'type' => 2,
    ],
    '/app/development-programme/test' => [
        'type' => 2,
    ],
    '/app/development-programme/*' => [
        'type' => 2,
    ],
    '/app/error/browser' => [
        'type' => 2,
    ],
    '/app/error/status907' => [
        'type' => 2,
    ],
    '/app/error/test' => [
        'type' => 2,
    ],
    '/app/error/*' => [
        'type' => 2,
    ],
    '/app/faiv-admin/faiv' => [
        'type' => 2,
    ],
    '/app/faiv-admin/get-users' => [
        'type' => 2,
    ],
    '/app/faiv-admin/test' => [
        'type' => 2,
    ],
    '/app/faiv-admin/*' => [
        'type' => 2,
    ],
    '/app/mgsu-admin/objects-table' => [
        'type' => 2,
    ],
    '/app/organization/info' => [
        'type' => 2,
    ],
    '/app/organization/user-info' => [
        'type' => 2,
    ],
    '/app/organization/update' => [
        'type' => 2,
    ],
    '/app/organization/list-object' => [
        'type' => 2,
    ],
    '/app/organization/table-list' => [
        'type' => 2,
    ],
    '/app/organization/object-view' => [
        'type' => 2,
    ],
    '/app/organization/set-recomend-status' => [
        'type' => 2,
    ],
    '/app/organization/set-not-recomend-status' => [
        'type' => 2,
    ],
    '/app/organization/set-to-work-status' => [
        'type' => 2,
    ],
    '/app/organization/set-approve-status-dep' => [
        'type' => 2,
    ],
    '/app/organization/set-rejected-status-dep' => [
        'type' => 2,
    ],
    '/app/organization/set-status-dku' => [
        'type' => 2,
    ],
    '/app/organization/set-status-dep' => [
        'type' => 2,
    ],
    '/app/organization/get-approve-status' => [
        'type' => 2,
    ],
    '/app/organization/test' => [
        'type' => 2,
    ],
    '/app/program/approve' => [
        'type' => 2,
    ],
    '/app/program/test' => [
        'type' => 2,
    ],
    '/app/program/*' => [
        'type' => 2,
    ],
    '/app/program-objects/index' => [
        'type' => 2,
    ],
    '/app/program-objects/send-event' => [
        'type' => 2,
    ],
    '/app/program-objects/view' => [
        'type' => 2,
    ],
    '/app/program-objects/update' => [
        'type' => 2,
    ],
    '/app/program-objects/add-docs' => [
        'type' => 2,
    ],
    '/app/program-objects/get-all-obj-files' => [
        'type' => 2,
    ],
    '/app/program-objects/delete-docs' => [
        'type' => 2,
    ],
    '/app/program-objects/delete' => [
        'type' => 2,
    ],
    '/app/program-objects/file-upload' => [
        'type' => 2,
    ],
    '/app/program-objects/status-realize' => [
        'type' => 2,
    ],
    '/app/program-objects/test' => [
        'type' => 2,
    ],
    '/app/program-objects/*' => [
        'type' => 2,
    ],
    '/app/test/index' => [
        'type' => 2,
    ],
    '/app/test/test' => [
        'type' => 2,
    ],
    '/app/test/*' => [
        'type' => 2,
    ],
    '/rest/cities/by-id' => [
        'type' => 2,
    ],
    '/rest/cities/*' => [
        'type' => 2,
    ],
    '/rest/organizations/all' => [
        'type' => 2,
    ],
    '/rest/organizations/by-username' => [
        'type' => 2,
    ],
    '/rest/organizations/current' => [
        'type' => 2,
    ],
    '/rest/organizations/by-id' => [
        'type' => 2,
    ],
    '/rest/organizations/*' => [
        'type' => 2,
    ],
    '/rest/program/get-by-id-org' => [
        'type' => 2,
    ],
    '/rest/program/*' => [
        'type' => 2,
    ],
    '/rest/program-objects/by-id' => [
        'type' => 2,
    ],
    '/rest/program-objects/get-status' => [
        'type' => 2,
    ],
    '/rest/program-objects/*' => [
        'type' => 2,
    ],
    '/rest/system/get-page' => [
        'type' => 2,
    ],
    '/rest/system/get-user' => [
        'type' => 2,
    ],
    '/rest/system/*' => [
        'type' => 2,
    ],
    '/rest/upload/upload' => [
        'type' => 2,
    ],
    '/rest/upload/download' => [
        'type' => 2,
    ],
    '/rest/upload/test' => [
        'type' => 2,
    ],
    'dku_user' => [
        'type' => 1,
        'children' => [
            'dku',
        ],
    ],
];
