<?php

namespace common\widgets\videoRoom;

use yii\base\Widget;
use common\widgets\videoRoom\videoWidgetAsset;
use yii\helpers\VarDumper;

class videoWidget extends Widget
{

    public $members;
    public $myRoom;
    public $is_owner;
    public $is_allowed;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        videoWidgetAsset::register($this->getView());

        return $this->render(
            '_video',
            [
                'members' => $this->members,
                'myRoom' => $this->myRoom,
                'is_owner' => $this->is_owner,
                'is_allowed' => $this->is_allowed,
            ]
        );
    }
}
