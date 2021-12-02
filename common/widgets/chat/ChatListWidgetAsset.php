<?php

namespace common\widgets\chat;

use yii\web\AssetBundle;

class ChatListWidgetAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/chat/assets';

    public $js = [
        'js/mqttChatHandler.js',
        'js/chatHome.js',
    ];

    public $css = [
        'css/list.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'frontend\assets\MomentJs\MomentJsAsset'
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}
