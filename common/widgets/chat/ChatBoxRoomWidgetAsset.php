<?php

namespace common\widgets\chat;

use yii\web\AssetBundle;

class ChatBoxRoomWidgetAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/chat/assets';

    public $js = [
        'js/moment.min.js',
        'js/mqttChatHandler.js',
        'js/boxRoom.js',
    ];

    public $css = [
        'css/box.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}
