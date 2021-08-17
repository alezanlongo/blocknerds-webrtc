<?php
/* @var $this yii\web\View */

use yii\web\View;
use yii\widgets\Pjax;
use common\models\User;
use yii\bootstrap4\Modal;
use yii\web\JsExpression;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->registerJsFile(
    "https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.9/jquery.datetimepicker.full.min.js",
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);

$this->registerCssFile(
    "https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.9/jquery.datetimepicker.css"
);

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

$this->registerJsVar('user_id',   Yii::$app->getUser()->getId());

$this->registerJsVar('roomMaxMembersAllowed', Yii::$app->params['janus.roomMaxMembersAllowed'], View::POS_END);

$this->title = "Room's calendar";
?>

<div id="calendar"></div>

<?
$form = ActiveForm::begin([
    'id' => 'formUpdateSchedule',
]);

Modal::begin([
    'title' => 'Scheduled room',
    'id' => 'scheduledRoom',
    'footer' => Html::submitButton('Save', ['class' => 'btn btn-primary', 'id' => 'btnModifySchedule'])
]);

Pjax::begin(['id' => 'calendar-request', "options" => ["class" => ""]]);

echo Html::input('hidden', 'room_id', $roomSelected ? $roomSelected->id : null);
?>
<div class="container">
    <div class="modal-body">

        <?php
        if ($roomSelected && $roomSelected->owner_id == $user_id) {
        ?>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label class="control-label" for="title">Title</label>
                        <?= Html::input('text', 'title', $roomSelected ? $roomSelected->title : null, ['class' => 'form-control']) ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="input-group mb-3">
                        <?= Html::input('text', 'roomLink', $roomSelected ? Url::to('room/' . $roomSelected->uuid, true) : null, ['readonly' => true, 'class' => 'form-control']) ?>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard();return false;">Copy link</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col text-center">
                    <p class="control-label text-left" for="datetimepicker">Date & time</p>
                    <?= Html::input('hidden', 'date', $roomSelected ? date("Y-m-d", $roomSelected->scheduled_at) : null) ?>
                    <?= Html::input('hidden', 'time', $roomSelected ? date("H:i:00", $roomSelected->scheduled_at) : null) ?>
                    <input type="text" name="datetimepicker" id="datetimepicker" value="<?= $roomSelected ? date("Y-m-d H:i:00", $roomSelected->scheduled_at) : null; ?>">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label class="control-label" for="duration">Duration</label>
                        <?
                        $items = [
                            '900' => '15 minutes',
                            '1800' => '30 minutes',
                            '3600' => '1 hour',
                            '5400' => '1 hour and 30 minutes',
                            '7200' => '2 hours'
                        ];

                        echo Html::dropDownList(
                            'duration',
                            $roomSelected->duration,
                            $items,
                            ['class' => 'form-control', 'prompt' => 'Select duration'],
                        );
                        ?>
                    </div>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="row">
                <div class="col">
                    <h1 class="text-capitalize"><?= $roomSelected ? $roomSelected->title : null; ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p><?= $roomSelected ? $formatter->asDatetime($roomSelected->scheduled_at, 'medium') : null; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>Duration: <?= $roomSelected ? $formatter->asDuration($roomSelected->duration, 'relativeTime') : null; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="input-group mb-3">
                        <?= Html::input('text', 'roomLink', $roomSelected ? Url::to('room/' . $roomSelected->uuid, true) : null, ['readonly' => true, 'class' => 'form-control']) ?>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard();return false;">Copy link</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }

        if ($roomSelected && $roomSelected->owner_id == $user_id) {

            echo $form->field(new User, 'username')->widget(Select2::class, [
                'options' => ['placeholder' => 'Search for a user ...', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 2,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['user-list']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(user) { return user.username; }'),
                    'templateSelection' => new JsExpression('function (user) { return user.username; }')
                ],
                'pluginEvents' => [
                    //     "change" => "function(e) { console.log('change', e); }",
                    //     "select2:opening" => "function(e) { console.log('select2:opening', e); }",
                    //     "select2:open" => "function(e) { console.log('open', e); }",
                    //     "select2:closing" => "function(e) { console.log('close', e); }",
                    //     "select2:close" => "function(e) { console.log('close', e); }",
                    //     "select2:selecting" => "function(e) { console.log('selecting', e); }",
                    "select2:select" => "function(e) { console.log(e); addMemberToList(e.params.data); }",
                    //     "select2:unselecting" => "function(e) { console.log('unselecting', e); }",
                    //     "select2:unselect" => "function(e) { console.log('unselect', e); }"
                ]
            ]);
        }

        ?>
        <div class="row">
            <div class="col text-left">
                <h3>Current members</h3>
                <ul class="list-group current-member-list">
                    <?php
                    if (count($roomMembers) > 0) {
                        foreach ($roomMembers as $member) {
                            $removeButton = '<a href="#"><i class="fas fa-times-circle" onClick="removeMemberFromList(' . $member->user_id . ');"></i></a>';
                            if ($roomSelected->owner_id == $user_id) {
                                $removeButton = ($roomSelected->owner_id != $member->user_id ? $removeButton : null);
                            } else {
                                $removeButton = ($member->user_id == $user_id ? $removeButton : null);
                            }
                    ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center" data-member-id="<?= $member->user_id ?>">
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

ActiveForm::end();
?>