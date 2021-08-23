<?php

namespace common\widgets\modalScheduleRoom;

use yii\base\Widget;

class ModalScheduleRoomWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render(
            '_modal',
            [
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
