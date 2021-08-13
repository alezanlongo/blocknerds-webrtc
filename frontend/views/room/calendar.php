<?php
/* @var $this yii\web\View */

use yii\web\View;
use yii\widgets\Pjax;
use common\models\User;
use yii\bootstrap4\Modal;
use yii\web\JsExpression;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJsVar('user_id',   Yii::$app->getUser()->getId());

$this->registerJsVar('events', $events, View::POS_BEGIN);

$this->registerJsFile(
    "https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js",
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);

$this->registerCssFile(
    'https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.css',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/roomCalendar.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);

$this->title = "Room's calendar";

?>
<div id="calendar"></div>

<?
Modal::begin([
    'title' => 'Scheduled room',
    'id' => 'scheduledRoom',
    // 'footer' => Html::submitButton('Save', ['class' => 'btn btn-primary', 'id' => 'btnModifySchedule'])
]);

Pjax::begin(['id' => 'calendar-request', "options" => ["class" => ""]]);
?>

<div class="container">
    <div class="modal-body">
        <h1 class="text-capitalize"><?= $roomSelected ? $roomSelected->title : null; ?></h1>
        <p><?= $roomSelected ? $formatter->asDatetime($roomSelected->scheduled_at, 'medium') : null; ?></p>
        <p>Duration: <?= $roomSelected ? $formatter->asDuration($roomSelected->duration, 'relativeTime') : null; ?></p>

        <?
        if ($roomSelected && $roomSelected->owner_id == $user_id) {

            $form = ActiveForm::begin([
                'id' => 'formCreateSchedule',
            ]);

            echo $form->field(new User, 'username')->widget(Select2::class, [
                'options' => ['placeholder' => 'Search for a user ...', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => false,
                    'minimumInputLength' => 2,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['user-list', 'room_id' => $roomSelected->id]),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(user) { return user.username; }'),
                    'templateSelection' => new JsExpression('function (user) { return user.username; }')
                ],
                'pluginEvents' => [
                    // "change" => "function() { console.log('change'); }",
                    // "select2:opening" => "function() { console.log('select2:opening'); }",
                    // "select2:open" => "function() { console.log('open'); }",
                    // "select2:closing" => "function() { console.log('close'); }",
                    // "select2:close" => "function() { console.log('close'); }",
                    // "select2:selecting" => "function() { console.log('selecting'); }",
                    "select2:select" => "function(e) { addMemberToList(e.params.data, '" . $roomSelected->uuid . "', " . $roomSelected->id . "); }",
                    // "select2:unselecting" => "function() { console.log('unselecting'); }",
                    // "select2:unselect" => "function() { console.log('unselect'); }"
                ]
            ]);

            ActiveForm::end();
        }

        ?>
        <div class="row">
            <div class="col text-left">
                <h3>Members</h3>
                <ul class="list-group">
                    <?php
                    if (count($roomMembers) > 0) {
                        foreach ($roomMembers as $member) {

                            $removeButton = '<a href="#"><i class="fas fa-times-circle" onClick="removeMemberFromList(' . $roomSelected->id . ',' . $member->user_id . ');"></i></a>';
                            if ($roomSelected->owner_id == $user_id) {
                                $removeButton = ($roomSelected->owner_id != $member->user_id ? $removeButton : null);
                            } else {
                                $removeButton = ($member->user_id == $user_id ? $removeButton : null);
                            }
                    ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= $member->user->username ?>
                                <?= $removeButton ?>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <?
        Pjax::end();
        ?>
    </div>
</div>
<?
Modal::end();
?>