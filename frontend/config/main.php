<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'room/calendar',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'POST room/create' => 'room/create',
                'POST room/create-schedule' => 'room/create-schedule',
                'GET room/user-list' => 'room/user-list',
                'GET room/waiting/<uuid>' => 'room/waiting',
                'GET room/calendar' => 'room/calendar',
                'GET room/calendar/events/<id>' => 'room/fetch-calendar-events',
                'GET room/<uuid>' => 'room',
                'POST room/join/request' => 'room/join-request',
                'POST room/time/expired' => 'room/time-expired',
                'POST room/time/add' => 'room/add-time',
                'POST room/join/<action:(allow|deny)>' => 'room/join',
            ],
        ],
    ],
    'params' => $params,
];
