<?php

namespace common\widgets\modalScheduledRoomMember;

use yii\base\Widget;

class ModalScheduledRoomMemberWidget extends Widget
{
    public $user_profile_id;
    public $room_id;
    public $uuid;
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
                'user_profile_id' => $this->user_profile_id,
                'room_id' => $this->room_id,
                'uuid' => $this->uuid,
                'title' => $this->title,
                'duration' => $this->duration,
                'scheduled_at' => $this->scheduled_at,
                'members' => $this->members,
            ]
        );
    }
}
