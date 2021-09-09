<?php

namespace common\widgets\cardNextOrInProgressMeeting;

use yii\base\Widget;

class cardNextOrInProgressMeetingWidget extends Widget
{
    public $title;
    public $text;
    public $url;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render(
            '_modal',
            [
                'title' => $this->title,
                'text' => $this->text,
                'url' => $this->url,
            ]
        );
    }
}
