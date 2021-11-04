<?php

namespace common\widgets\chat;

use yii\base\Widget;
use yii\helpers\VarDumper;

class ChatListWidget extends Widget
{

    public $recentChat = [];
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        ChatListWidgetAsset::register($this->getView());

        return $this->render(
            '_list',
            [
                'recentChat'=>$this->recentChat,
            ]
        );
    }
}
