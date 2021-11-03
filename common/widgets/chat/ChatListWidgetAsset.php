<?php

namespace common\widgets\chat;

use yii\web\AssetBundle;

class ChatListWidgetAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/chat/assets';

    public $js = [
        'js/list.js',
        'js/mqttChatHandler.js',
    ];

    public $css = [
        'css/list.css',
    ];

    public $depends = [
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}
