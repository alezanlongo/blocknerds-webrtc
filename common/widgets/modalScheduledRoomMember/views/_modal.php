<?php

use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$formatter = \Yii::$app->formatter;

Modal::begin([
    'title' => 'Scheduled room',
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
                <h1 class="text-capitalize"><?= $title ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><?= $formatter->asDatetime($scheduled_at, 'medium') ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>Duration: <?= $formatter->asDuration($duration, 'relativeTime') ?></p>
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
            <div class="col text-left">
                <h3>Current members</h3>
                <ul class="list-group current-member-list">
                    <?php
                    if (count($members) > 0) {
                        foreach ($members as $member) {
                            $removeButton = '<a href="#"><i class="fas fa-times-circle" onClick="removeMemberFromList(' . $member->user_id . ');"></i></a>';
                            $removeButton = ($member->user_id == $user_id ? $removeButton : null);
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
    </div>
</div>

<?
ActiveForm::end();

Modal::end();

?>