<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
// $routes = require __DIR__ . '/routes/MainRouter.php';

$config = [
    'id' => 'basic',
    'name' => 'Модернизация инфраструктуры',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'defaultRoute' => 'app/program',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@mdm/admin' => '@app/widgets/yii2-admin',
        '@webroot' => '@app/web'
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                ]
            ],

        ]
    ],

    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'KNbbRnlbgg_iYBM3JO7rQV80xzojoned',
            'parsers' => [
                'multipart/form-data' => 'yii\web\MultipartFormDataParser'
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/comment',
                    'pluralize' => false
                ],


                'shit-table/data' => 'api/shit/data',

                'api/set-status/approved/dep/<obj_id:\d+>' => '/app/organization/set-approve-status-dep',
                'api/set-status/rejected/dep/<obj_id:\d+>' => '/app/organization/set-rejected-status-dep',
                'api/set-status/dep/<org_id:\d+>' => '/app/organization/set-status-dep',
                'api/set-status/dku/<org_id:\d+>' => '/app/organization/set-status-dku',

                'api/set-status/recomend/<obj_id:\d+>' => '/app/organization/set-recomend-status',
                'api/set-status/not-recomend/<obj_id:\d+>' => '/app/organization/set-not-recomend-status',
                'api/set-status/to-work/<obj_id:\d+>' => '/app/organization/set-to-work-status',
                'api/get-status/<obj_id:\d+>' => 'app/organization/get-approve-status',

                'admin/faiv' => 'app/faiv-admin/faiv',
                'faiv-admin/get/users/<offset:\d+>' => 'app/faiv-admin/get-users',


                'api/v2/comments/all/<id_obj:\d+>' => 'api/com/get-comments',
                'api/v2/comments/save' => 'api/com/save-comment',
                'api/v2/comments/<id_comment:\d+>/delete' => 'api/com/delete-comment',

                'api/permissions' => 'api/permission/permissions',
                'api/comment/obj/<id:\d+>' => 'api/comment/obj',
                'program' => 'app/program',
                '' => 'app/program',
                'login' => 'site/login',
                'error/browser' => 'app/error/browser',
                'error/status907' => 'app/error/status907',
                'program/view' => 'app/development-programme',
                'program/add-doc/<id:\d+>' => 'app/development-programme/add-doc',
                'program/delete-doc/<id:\d+>' => 'app/development-programme/delete-doc',
                'program/check-doc/<id:\d+>' => 'app/development-programme/check-doc',
                'program/download-doc/<id:\d+>' => 'app/development-programme/download-doc',
                'program/object/create' => 'app/program-objects/create',
                'program/object/view/<id:\d+>' => 'app/program-objects/view',
                'program/object/update/<id:\d+>' => 'app/program-objects/update',
                'program/object/add-docs/<id:\d+>' => 'app/program-objects/add-docs',
                'program/object/download-doc/<id_obj:\d+>' => 'app/program-objects/download-doc',
                'program/object/delete-docs/<id:\d+>' => 'app/program-objects/delete-docs',
                'program/object/delete/<id:\d+>' => 'app/program-objects/delete',
                'program/object/files/<id:\d+>' => 'app/program-objects/get-all-obj-files',
                'program/object/zip/<id:\d+>' => 'app/program-objects/zip',
                'program/export' => 'app/development-programme/export',
                'program/approve' => 'app/program/approve',
                'program/is-approve' => 'app/program/is-approve',
                'program/is-approve/<id_org:\d+>' => 'app/program/is-approve',
                'program-objects/export' => 'app/program-objects/export',
                'organization/export/<type:\d+>' => 'app/program/export',
                'organization/list' => 'app/organization/list',
                'organization/list/<id:\d+>' => 'app/organization/list-object',
                'organization/obj/<id:\d+>' => 'app/organization/object-view',
                'organization/info' => 'app/organization/info',
                'organization/update/<id:\d+>' => 'app/organization/update',
                'organization/user-info/<id_org:\d+>'=>'app/organization/user-info',
                'api/user_info_roles' =>'api/user-info/roles',
                'program/atz' => 'app/atz/index',
                'check' => 'app/mgsu-admin/view',

                'api/fileUpload/<id_obj:\d+>/<id_comment:\d+>' => '/rest/upload/upload',

                'api/file/download/<name:.+>' => 'rest/upload/download',

                'api/getUsersInfo/<id_org:\d+>'=>'api/user-info/users',

                'api/mgsu/main-table/<offset:\d+>' => '/app/mgsu-admin/main-table',
                'api/mgsu/objects-table/<offset:\d+>' => '/app/mgsu-admin/objects-table',
                
                'api/mgsu/count' => '/app/mgsu-admin/count',
                'api/object/get-status/<id:\d+>' => '/rest/program-objects/get-status',
                'api/get-object/<id:\d+>' => '/rest/program-objects/by-id',


                //НАДО ПЕРЕДЕЛАТЬ
                'api/org-table/<id:\d+>' => '/app/organization/table-list',
                //'api/object/<id:\d+>' => '/app/organization/get-object-by-id'
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],

    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'debug/*',
            'rest/*'
            //'admin/*'
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ],

    ],

    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
