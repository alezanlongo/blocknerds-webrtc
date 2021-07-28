<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'janusApi' => [
            'class' => common\components\JanusApiComponent::class,
            'url' => 'http://127.0.0.1',
            'port' => 8088,
            'uri' => 'janus',
            'password'=>'janusrocks'
        ]
    ],
];
