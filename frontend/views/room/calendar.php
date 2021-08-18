<?php
/* @var $this yii\web\View */

use yii\web\View;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\Fullcalendar\FullcalendarAsset;
use frontend\assets\Datetimepicker\DatetimepickerAsset;
use common\widgets\modalScheduleRoom\ModalScheduleRoomWidget;
use common\widgets\modalScheduledRoomOwner\ModalScheduledRoomOwnerWidget;
use common\widgets\modalScheduledRoomMember\ModalScheduledRoomMemberWidget;

DatetimepickerAsset::register($this);
FullcalendarAsset::register($this);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/roomCalendar.js',
    [
        'depends' => [
            "yii\web\JqueryAsset",
            // "frontend\assets\Fullcalendar\FullcalendarAsset",
            // "frontend\assets\Datetimepicker\DatetimepickerAsset",
        ],
        'position' => View::POS_END
    ]
);

$this->registerJsVar('user_id',   Yii::$app->getUser()->getId());

$this->registerJsVar('roomMaxMembersAllowed', Yii::$app->params['janus.roomMaxMembersAllowed'], View::POS_END);

$this->title = "Room's calendar";

$form = ActiveForm::begin(['action' => 'room/create']);

echo Html::submitButton("Start a quick meeting", ["class" => "btn btn-primary btn-lg", "id" => "btnStart"]);

echo Html::a(
    "Planning a meeting",
    null,
    [
        'onclick' => "$('#planningMeeting').modal('show');return false;",
        "class" => "btn btn-outline-secondary btn-lg", "id" => "btnPlanning"
    ]
);

ActiveForm::end();
?>

<div id="calendar"></div>

<?php
Pjax::begin(['id' => 'calendar-request', "options" => ["class" => ""]]);

if ($roomSelected) {
    if ($roomSelected->owner_id == $user_id) {
        echo ModalScheduledRoomOwnerWidget::widget([
            'user_id' => $user_id,
            'room_id' => $roomSelected->id,
            'uuid' => $roomSelected->uuid,
            'owner_id' => $roomSelected->owner_id,
            'title' => $roomSelected->title,
            'duration' => $roomSelected->duration,
            'scheduled_at' => $roomSelected->scheduled_at,
            'members' => $roomMembers
        ]);
    } else {
        echo ModalScheduledRoomMemberWidget::widget([
            'user_id' => $user_id,
            'room_id' => $roomSelected->id,
            'uuid' => $roomSelected->uuid,
            'title' => $roomSelected->title,
            'duration' => $roomSelected->duration,
            'scheduled_at' => $roomSelected->scheduled_at,
            'members' => $roomMembers
        ]);
    }
}

Pjax::end();

echo ModalScheduleRoomWidget::widget();

Modal::begin([
    'title' => 'Planning a meeting...',
    'id' => 'planningMeetingSuccessfully',
]);
Html::tag("h1");
Html::tag("p");
Modal::end();
?>