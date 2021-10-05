<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=db;dbname=yii_app',
            'username' => 'dev',
            'password' => 'd3v',
            'charset' => 'utf8',
            'schemaMap' => [
                'pgsql'=> [
                    'class'=>'yii\db\pgsql\Schema',
                    'defaultSchema' => 'public' //specify your schema here
                ]
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
    ],
];
