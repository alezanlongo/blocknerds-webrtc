<?php

use yii\log\FileTarget;

return [
    'bootstrap' => [
        // 'queue', // The component registers its own console commands
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        "log" => [
            "traceLevel" => YII_DEBUG ? 3 : 0,
            "targets" => [
                [
                    "class" => FileTarget::class,
                    "levels" => ["error", "warning"]
                ]
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'port' => '1025',
                'host' => 'mail'
            ],
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
        ],
        'mqtt' => [
            'class' => common\components\MqttComponent::class,
            'host' => 'rabbitmq',
            'port' => 1883
        ],
        'janusApi' => [
            'class' => common\components\JanusApiComponent::class,
            'url' => 'http://janus',
            'port' => 8088,
            'uri' => 'janus',
            'apiSecret' => 'janusrocks',
            'adminSecret' => 'janusoverlord',
            'adminPort' => 7088,
            'adminUri' => 'admin',
            'adminKey' => 'supersecret',
            'tokenAuthSecret' => 'fcknlorenzo',
            'adminKey' => 'supersecret',
            'storedAuth' => true

        ],
        'athenaComponent' => [
            'class' => common\components\AthenaComponent::class,
        ],
    ],
];
