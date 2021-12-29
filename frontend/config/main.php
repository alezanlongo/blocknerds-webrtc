<?php

use frontend\assets\adminlte\AdminLteAsset;
use frontend\assets\fontawesome\FontAwesomeAsset;
use yii\bootstrap5\BootstrapAsset;

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
        'assetManager' => [
            'bundles' => [
                // 'appendTimestamp' => true,
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js',
                    ]
                ],

                AdminLteAsset::class => [
                    "css" => [
                        'css/adminlte.css',
                        'css/sidebar.css',
                        'css/dark/adminlte-dark-addon.css',
                        'lib/overlayscrollbars/css/OverlayScrollbars.min.css',
                        'lib/@fortawesome/fontawesome-free/css/all.min.css',
                    ],
                    'js' => [
                        'js/adminlte.js',
                        'js/sidebar.js',
                        'lib/overlayscrollbars/js/jquery.overlayScrollbars.min.js',
                    ],
                    // 'depends' => [FontAwesomeAsset::class]
                ],
                // BootstrapAsset::class => [
                //     'css' => [],
                //     'js' => [],
                //     'depends' => [FontAwesomeAsset::class]
                // ],
            ]
        ],
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
                'GET room/test' => 'room/test',
                'POST room/create-schedule' => 'room/create-schedule',
                'GET room/user-list' => 'room/user-list',
                'GET room/admin-test' => 'room/testing-admin',
                'GET room/waiting/<uuid>' => 'room/waiting',
                'GET room/calendar' => 'room/calendar',
                'GET room/calendar/events/<id>' => 'room/fetch-calendar-events',
                'GET room/<uuid>' => 'room',
                'POST room-moderate/<roomUuid>/<profileId>' => 'room/moderate-member',
                'POST room/<uuid>/kick' => 'room/kick-member',
                'POST room/join/request' => 'room/join-request',
                'POST room/time/expired' => 'room/time-expired',
                'POST room/time/add' => 'room/add-time',
                'POST room/join/<action:(allow|deny)>' => 'room/join',
                'GET user/get-profile/<profile_id>' => 'user/get-profile',
                'GET,POST user/profile-image' =>'user/profile-image',
                'POST room/toggle-media' => 'room/toggle-media',
                'GET chat/<channel>' => 'chat/get-chat',
                'POST chat/request-subscribe' => 'chat/request-to-subscribe-channel',
                'POST chat-test/message-listener' => 'chat-test/message-listener',
                'POST photo/add' => 'photo/add',
                'POST janus/event' => 'janus-event/create',
                'POST ice/event' => 'ice-event/create',
                'POST,GET room/capture-member-image/<roomUuid>/<profileId>' => 'room/capture-member-image',
                'POST room/capture-member-image/<roomUuid>/<profileId>' => 'room/capture-member-image',
                'GET room/capture-member-image-params/<roomUuid>' => 'room/get-capture-member-image-params',
                'POST room/capture-member-image-upload/<roomUuid>/<captureId>' => 'room/upload-capture-member-image'
            ],
        ],
    ],
    'params' => $params,
];
