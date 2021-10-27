<?php

namespace common\widgets\chat;

use yii\web\AssetBundle;

class ChatBoxWidgetAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/chat/assets';

    public $js = [
        'js/box.js',
    ];

    public $css = [
        'css/box.css',
    ];

    public $depends = [
        // 'yii\web\JqueryAsset',
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}
