<?php

use common\models\User;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$btnOpenMeeting = Html::a(
    '  <i class="fas text-secondary fa-external-link-alt"></i>',
    'room/' . $uuid,
    [
        'onclick' => 'window.open("/room/' . $uuid . '");return false;'
    ]
);

Modal::begin([
    'title' => 'Scheduled room ' . $btnOpenMeeting,
    'id' => 'scheduledRoom',
    'footer' => Html::submitButton('Submit', ['class' => 'btn btn-primary', 'onclick' => "updateSchedule();return false;"])
]);

$form = ActiveForm::begin([
    'id' => 'formUpdateSchedule',
]);

echo Html::input('hidden', 'room_id', $room_id);
?>

<div class="container">
    <div class="modal-body">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="control-label" for="title">*Title</label>
                    <?= Html::input('text', 'title', $title, ['class' => 'form-control']) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <?= Html::input('text', 'roomLink', Url::to('room/' . $uuid, true), ['readonly' => true, 'class' => 'form-control']) ?>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard();return false;">Copy link</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="control-label" for="title">Description</label>
                    <?= Html::textarea('description', $description, ['class' => 'form-control']) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col text-center">
                <p class="control-label text-left" for="datetimepicker">*Date & time</p>
                <?= Html::input('hidden', 'date', date("Y-m-d", $scheduled_at)) ?>
                <?= Html::input('hidden', 'time', date("H:i:00", $scheduled_at)) ?>
                <?= Html::input('text', 'datetimepicker', date("Y-m-d H:i:00", $scheduled_at), ["id" => "datetimepicker"]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="control-label" for="duration">Reminder time</label>
                    <?
                    echo Html::dropDownList(
                        'reminder_time',
                        $reminder_time,
                        $itemsReminder,
                        ['class' => 'form-control'],
                    );
                    ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="control-label" for="duration">Duration</label>
                    <?
                    echo Html::dropDownList(
                        'duration',
                        $duration,
                        $itemsDuration,
                        ['class' => 'form-control', 'prompt' => 'Select duration'],
                    );
                    ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="control-label" for="duration">Allow waiting</label>
                    <?
                    echo Html::checkbox(
                        'allow_waiting',
                        $allow_waiting,
                        $itemsReminder,
                        ['class' => 'form-control'],
                    );
                    ?>
                </div>
            </div>
        </div>

        <?php
        echo $form->field(new User, 'username')->widget(Select2::class, [
            'options' => ['placeholder' => 'Search for a user ...', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 2,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => Url::to(['user-list']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(user) { return user.username; }'),
                'templateSelection' => new JsExpression('function (user) { return user.username; }')
            ],
            'pluginEvents' => [
                // "change" => "function(e) { console.log('change', e); test(e.params.data); }",
                // "select2:opening" => "function(e) { console.log('select2:opening', e); test(e.params.data); }",
                // "select2:open" => "function(e) { console.log('open', e); test(e.params.data); }",
                // "select2:closing" => "function(e) { console.log('closing', e); test(e.params.data); }",
                // "select2:close" => "function(e) { console.log('close', e); test(e.params.data); }",
                // "select2:selecting" => "function(e) { selectingMemberList(e.params.data); }",
                "select2:select" => "function(e) { console.log(e); addMemberToList(e.params.data); }",
                // "select2:unselecting" => "function(e) { unselectingMemberList(e.params.data); }",
                // "select2:unselect" => "function(e) {unselectMemberList(e.params.data); }"
            ]
        ]);
        ?>

        <div class="row">
            <div class="col text-left">
                <h3>Current members</h3>
                <ul class="list-group current-member-list">
                    <?php
                    if (count($members) > 0) {
                        foreach ($members as $member) {
                            $removeButton = '<a href="#"><i class="fas fa-times-circle" onClick="removeMemberFromList(' . $member->user_profile_id . ');"></i></a>';
                            $removeButton = ($owner_id != $member->user_profile_id ? $removeButton : null);
                    ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center" data-member-id="<?= $member->user_profile_id ?>">
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
    </div>
</div>

<?
ActiveForm::end();

Modal::end();

?>