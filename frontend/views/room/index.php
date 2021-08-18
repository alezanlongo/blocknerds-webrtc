<?php
/* @var $this yii\web\View */

use common\models\RoomRequest;
use frontend\assets\Janus\JanusAsset;
use yii\web\View;
use yii\helpers\Html;
use yii\widgets\Pjax;
use frontend\assets\pahoMqtt\PahoMqttAsset;
use frontend\assets\room\RoomAsset;
use yii\bootstrap4\Button;
use yii\bootstrap4\Modal;

JanusAsset::register($this);
$this->registerAssetBundle(PahoMqttAsset::class);
$this->registerAssetBundle(RoomAsset::class);

$user_id =  Yii::$app->getUser()->getId();
$this->registerJsVar('limitMembers', $limit_members, View::POS_END);
$this->registerJsVar('countRequest', count($requests), View::POS_END);
$this->registerJsVar('myRoom', $uuid, View::POS_END);
$this->registerJsVar('username',  Yii::$app->getUser()->getIdentity()->username, View::POS_END);
$this->registerJsVar('userId', $user_id, View::POS_END);
$this->registerJsVar('isOwner', $is_owner, View::POS_END);
$this->registerJsVar('isAllowed', $is_allowed, View::POS_END);
$this->registerJsVar('mytoken', $token, View::POS_END);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/mqttHandler.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/room.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);

$this->title = 'The Room';

?>
<div class="room  mw-100">
    <? if ($is_owner || $is_allowed) { ?>
        <div class="join-again d-none">
            <div class="card">
                <div class="card-title">
                    <?= Html::tag("h4", "You left of the room") ?>
                </div>
                <div class="card-body">
                    <?= Html::tag("button", "Join again",  ["class" => "btn btn-primary btn-join-again"]) ?>
                    <?= Html::a('Go home', ['/room/create'], ['class' => 'btn btn-default text-white']) ?>
                </div>
            </div>
        </div>
        <div class="room-videos">
            <div class="room-section d-flex flex-wrap justify-content-center">
                <?php for ($i = 0; $i < $limit_members; $i++) { ?>
                    <div class="box<?= $i ?> box border d-none bg-dark" data-id="<?= $i ?>">
                        <div class="content-video" id="video-source<?= $i ?>">
                            <h1 class="text-light username-on-call"> <?= $i ?></h1>

                            <div class="control-owner d-flex ">
                                <?php if ($is_owner && $i > 0) { ?>
                                    <button onclick="muteMember(<?= $i ?>)" class="btn btn-default btn-mute text-white">Mute</button>
                                <?php } ?>
                                <!-- <button onclick="pinMember(<?= $i ?>)" class="btn btn-default btn-pin text-white">Pin</button> -->
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="room-user-control bg-dark">
                <div class="other-stuff">
                    <?= Html::tag('button', "Leaving", ["class" => "btn btn-danger btn-leave"]) ?>
                </div>
                <div class="content-calls overflow-auto"></div>
            </div>

            <div class="control-section border text-light bg-dark">
                <button class="btn btn-default text-white " id="mute" onclick="toggleMute()">Mute</button>
                <button class="btn btn-default text-white" id="no-video" onclick="toggleVideo()">Video</button>
            </div>
        </div>
    <? } ?>



    <? Modal::begin([
        'title' => 'Require to join...',
        'id' => 'pendingRequests',
    ]);

    Pjax::begin(['id' => 'room-request', "options" => []]);

    if ($is_owner) {
        if (count($requests) > 0) {
            foreach ($requests as $request) {
    ?>
                <div class="card mb-3">
                    <div class="card-header"><?= $request->user->username ?> wants to join the room</div>
                    <div class="card-body">
                        <?
                        echo Html::submitButton('Allow to join', ['class' => 'btn btn-success', 'id' => 'btnAllow', 'data-user' => $request->user_id]);
                        echo Html::submitButton('Deny to join', ['class' => 'btn btn-danger', 'id' => 'btnDeny', 'data-user' => $request->user_id]);
                        ?>
                    </div>
                </div>
    <?
            }
        } else {
            echo "<script>if (window.jQuery) $('#pendingRequests').modal('hide');</script>";
            echo "<p class='text-info'>Well done, nothing to do here!.<p>";
        }
    }
    Pjax::end();

    Modal::end();

    Pjax::begin(['id' => 'room-member', "options" => []]);

    if (!$is_owner) {
        if ($request) {
            if ($request->status == RoomRequest::STATUS_DENY) {
                echo "<p class='text-danger'>Your join request has been denied.<p>";
                echo $request->attempts < RoomRequest::MAX_ATTEMPTS ? Html::submitButton('Ask for join again', ['class' => 'btn btn-primary', 'id' => 'btnJoin']) : null;
            } else if ($request->status == RoomRequest::STATUS_ALLOW) {
                // echo "<p class='text-primary'>Welcome to the room!<p>";
            } else {
                echo "<p class='text-info'>Your join request is waiting for approval.<p>";
            }
        } else {
            echo Html::submitButton('Join', ['class' => 'btn btn-primary', 'id' => 'btnJoin']);
        }
    }
    Pjax::end();
    ?>

</div><!-- room -->