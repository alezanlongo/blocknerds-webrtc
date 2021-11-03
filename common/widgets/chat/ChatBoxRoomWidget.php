<?php

namespace common\widgets\chat;

use yii\base\Widget;
use yii\helpers\VarDumper;

class ChatBoxRoomWidget extends Widget
{
    public $chats = [];
    public $user = null;
    public $room_id = null;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        ChatBoxRoomWidgetAsset::register($this->getView());

        return $this->render(
            '_boxRoom',
            [
                'chats' => $this->chats,
                'room_id' => $this->room_id,
            ]
        );
    }
}
