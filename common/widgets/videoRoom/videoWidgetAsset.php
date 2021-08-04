<?php

namespace common\widgets\videoRoom;

use yii\web\AssetBundle;

class videoWidgetAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/videoRoom/assets';

    public $js = [
        'js/mqtt.js',
        // 'js/room.js',
        // 'js/janusFunctionsImp.js',
    ];

    public $css = [
        'css/room.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}
