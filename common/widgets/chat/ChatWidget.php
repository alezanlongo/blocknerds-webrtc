<?php

namespace common\widgets\chat;

use yii\base\Widget;
use yii\helpers\VarDumper;

class ChatWidget extends Widget
{

    public $users = [];
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        ChatWidgetAsset::register($this->getView());

        return $this->render(
            '_list',
            [
                'users'=>$this->users,
            ]
        );
    }
}
