<?php

namespace common\widgets\chat;

use yii\base\Widget;
use yii\helpers\VarDumper;

class ChatBoxWidget extends Widget
{

    public $users = [];
    public $chats = [];
    public $user = null;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        ChatBoxWidgetAsset::register($this->getView());

        return $this->render(
            '_box',
            [
                'users'=>$this->users,
                'user'=> $this->user,
                'chats'=> $this->chats,
                'isNew' => count($this->users) > 0 && $this->user === null
            ]
        );
    }
}
