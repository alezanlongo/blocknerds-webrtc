<?php

return [
    'components' => [
        'db' => [
            /*'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',*/
            'class'     => 'yii\db\Connection',
            'dsn'       => 'pgsql:host=pgsql;dbname=webrtc_blocknerds',
            'username'  => 'docker',
            'password'  => 'aa11aa',
            'charset'   => 'utf8',
            'schemaMap' => [
                'pgsql' => [
                    'class'=>'yii\db\pgsql\Schema',
                    'defaultSchema' => 'public' //specify your schema here
                ]
            ],
            'enableSchemaCache' => true,
            // Duration of schema cache.
            'schemaCacheDuration' => 3600,
            // Name of the cache component used to store schema information
            'schemaCache' => 'cache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
