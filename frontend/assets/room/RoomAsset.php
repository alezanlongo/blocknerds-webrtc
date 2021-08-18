<?php

namespace frontend\assets\room;

class RoomAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/room';
    public $css = [
        'css/main.css',
    ];

    public $js = [
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
}
