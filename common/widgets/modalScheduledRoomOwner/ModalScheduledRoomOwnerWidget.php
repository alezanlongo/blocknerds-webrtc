<?php

namespace common\widgets\modalScheduledRoomOwner;

use yii\base\Widget;

class ModalScheduledRoomOwnerWidget extends Widget
{
    public $user_profile_id;
    public $room_id;
    public $uuid;
    public $owner_id;
    public $title;
    public $description;
    public $duration;
    public $scheduled_at;
    public $reminder_time;
    public $allow_waiting;
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
                'user_profile_id' => $this->user_profile_id,
                'room_id' => $this->room_id,
                'uuid' => $this->uuid,
                'owner_id' => $this->owner_id,
                'title' => $this->title,
                'description'=> $this->description,
                'duration' => $this->duration,
                'scheduled_at' => $this->scheduled_at,
                'reminder_time' => $this->reminder_time,
                'allow_waiting' => $this->allow_waiting,
                'members' => $this->members,
                'itemsReminder' => [
                    '0' => 'Select option',
                    '900' => '15 minutes',
                    '1800' => '30 minutes',
                    '2700' => '45 minutes',
                    '3600' => '1 hour'
                ],
                'itemsDuration' => [
                    '900' => '15 minutes',
                    '1800' => '30 minutes',
                    '2700' => '45 minutes',
                    '3600' => '1 hour',
                    '4500' => '1 hour and 15 minutes',
                    '5400' => '1 hour and 30 minutes',
                    '6300' => '1 hour and 45 minutes',
                    '7200' => '2 hours'
                ]
            ]
        );
    }
}
