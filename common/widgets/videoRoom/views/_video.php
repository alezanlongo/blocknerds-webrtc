<?php

use yii\widgets\Pjax;

$this->registerJsVar('room_uuid', $myRoom);
$this->registerJsVar('user_id',  Yii::$app->getUser()->getId());
$this->registerJsVar('username',  Yii::$app->getUser()->getIdentity()->username);
$this->registerJsVar('is_owner', $is_owner);
$this->registerJsVar('is_allowed', $is_allowed);
?>




<? if ($is_owner || $is_allowed) { ?>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Local Video </span>
                    </h3>
                </div>
                <div class="panel-body" id="videolocal"></div>
            </div>
        </div>
    </div>
    <?php Pjax::begin(['id' => 'room-video', "options" => ["class" => "row"]]); ?>
    <?php foreach ($members as $key => $member) { ?>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Video #<?= $member->username ?> </span></h3>
                </div>
                <div class="panel-body relative" id="videoremote<?= $key + 1 ?>"></div>
            </div>
        </div>
    <?php } ?>
    <?php Pjax::end(); ?>
<? } ?>