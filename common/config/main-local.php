<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=pgsql;dbname=webrtc_blocknerds',
            'username' => 'docker',
            'password' => 'aa11aa',
            'charset' => 'utf8',
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
