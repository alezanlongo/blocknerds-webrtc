<?php
/* @var $this yii\web\View */

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
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
    if ($roomSelected->meeting->owner_id == $user_id) {
        echo ModalScheduledRoomOwnerWidget::widget([
            'user_id' => $user_id,
            'room_id' => $roomSelected->id,
            'uuid' => $roomSelected->uuid,
            'owner_id' => $roomSelected->meeting->owner_id,
            'title' => $roomSelected->meeting->title,
            'duration' => $roomSelected->meeting->duration,
            'description' => $roomSelected->meeting->description,
            'reminder_time' => $roomSelected->meeting->reminder_time,
            'allow_waiting' => $roomSelected->meeting->allow_waiting,
            'scheduled_at' => $roomSelected->meeting->scheduled_at,
            'members' => $roomMembers
        ]);
    } else {
        echo ModalScheduledRoomMemberWidget::widget([
            'user_id' => $user_id,
            'room_id' => $roomSelected->id,
            'uuid' => $roomSelected->uuid,
            'title' => $roomSelected->meeting->title,
            'duration' => $roomSelected->meeting->duration,
            'scheduled_at' => $roomSelected->meeting->scheduled_at,
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

Modal::begin([
    'title' => 'Confirm meeting',
    'id' => 'confirmMeeting',
    'options' => [
        'data-backdrop' => "static",
        'data-keyboard' => "false"
    ],
]); 
echo Html::tag('h3','', ['class'=>'summaryTitle']);
echo Html::tag('p','', ['class'=>'summaryDescription']);
echo Html::tag('p','', ['class'=>'summaryTime']);
echo Html::tag('p','', ['class'=>'summaryDuration']);
echo Html::tag('p','', ['class'=>'summaryReminderTime']);
echo Html::tag('p','', ['class'=>'summaryIsWaiting']);
echo Html::tag('p','', ['class'=>'summaryMembers']);
?>
<div class="modal-footer">
    <p class="pull-left">
        <?= Html::tag('button','Cancel', [
            'class' => 'btn btn-default btnCancelMeet'
        ]); ?>
        <?= Html::tag('button','Confirm', [
            'class' => 'btn btn-primary btnConfirmMeet'
        ]); ?>
    </p>
</div>
<?php Modal::end(); ?>