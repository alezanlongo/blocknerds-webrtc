<?php

namespace common\widgets\modalScheduledRoomOwner;

use yii\base\Widget;

class ModalScheduledRoomOwnerWidget extends Widget
{
    public $user_id;
    public $room_id;
    public $uuid;
    public $owner_id;
    public $title;
    public $duration;
    public $scheduled_at;
    public $members;

    public function init()
    {
        parent::init();
    }
    
    public function run()
    {
        return $this->render(
            '_modal',
            [
                'user_id' => $this->user_id,
                'room_id' => $this->room_id,
                'uuid' => $this->uuid,
                'owner_id' => $this->owner_id,
                'title' => $this->title,
                'duration' => $this->duration,
                'scheduled_at' => $this->scheduled_at,
                'members' => $this->members,
                'itemsDuration' => [
                    '900' => '15 minutes',
                    '1800' => '30 minutes',
                    '2700' => '45 minutes',
                    '3600' => '1 hour',
                    '5400' => '1 hour and 30 minutes',
                    '6300' => '1 hour and 45 minutes',
                    '7200' => '2 hours'
                ]
            ]
        );
    }
}
