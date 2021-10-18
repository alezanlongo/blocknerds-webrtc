<?php

namespace frontend\assets\room;

class RoomAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/room';
    public $css = [
        'css/main.css',
    ];

    public $js = [
        'js/bootstrap.bundle.min.js',
        'js/moment.min.js',
        'js/boxesHandler.js',
        // 'js/countdown.js',
        'js/mqttHandler.js',
        'js/room.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
}
