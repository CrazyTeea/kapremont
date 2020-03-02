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
];
