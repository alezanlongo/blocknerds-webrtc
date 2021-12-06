<?php

namespace frontend\assets\room;

class RoomAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/room';
    public $css = [
        'css/main.css',
    ];

    public $js = [
        'js/boxesHandler.js',
        // 'js/countdown.js',
        'js/mqttHandler.js',
        'js/room.js',
        'js/switching.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'frontend\assets\MomentJs\MomentJsAsset'
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
}
