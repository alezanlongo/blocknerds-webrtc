<?php

use yii\widgets\Pjax;

$this->registerJsVar('room_uuid', $myRoom);
$this->registerJsVar('user_id',   Yii::$app->getUser()->getId());
$this->registerJsVar('username',  Yii::$app->getUser()->getIdentity()->username);
$this->registerJsVar('is_owner', $is_owner);
$this->registerJsVar('is_allowed', $is_allowed);

?>

<? if ($is_owner || $is_allowed) { ?>
    <?php Pjax::begin(['id' => 'room-video', "options" => ["class" => "room-section d-flex flex-wrap justify-content-center"]]); ?>
    <? foreach ($members as $key => $member) {  ?>
        <div class="box">
            <div class="card">
                <div class="card-body">
                    <div id="video-source<?= $member->id ?>">
                        <video class="rounded centered" id="myvideo<?= $member->id ?>" width="100%" height="100%" autoplay playsinline muted="muted">
                    </div>
                </div>
            </div>
        </div>
    <? } ?>
    </div>
    <?php Pjax::end(); ?>

    <div class="control-section border ">
        <button class="btn btn-default" id="mute" onclick="toggleMute()">Mute</button>
        <button class="btn btn-default c-white" id="unpublish" onclick="unpublishOwnFeed()">Video</button>
    </div>
<? } ?>
