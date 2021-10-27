<?php

namespace common\widgets\chat;

use yii\web\AssetBundle;

class ChatWidgetAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/chat/assets';

    public $js = [
        'js/main.js',
    ];

    public $css = [
        'css/main.css',
    ];

    public $depends = [
        // 'yii\web\JqueryAsset',
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}
