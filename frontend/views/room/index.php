<?php
/* @var $this yii\web\View */

use common\models\RoomRequest;
use frontend\assets\Janus\JanusAsset;
use yii\web\View;
use yii\helpers\Html;
use yii\widgets\Pjax;
use frontend\assets\pahoMqtt\PahoMqttAsset;
use yii\bootstrap4\Button;
use yii\bootstrap4\Modal;
use frontend\widgets\imageSlider\ImageSlider;

JanusAsset::register($this);
$this->registerAssetBundle(PahoMqttAsset::class);

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
            <button type="button" class="btn btn-primary btn-join-again">Join again</button>
        </div>
        <div class="room-videos">
            <div class="room-section d-flex flex-wrap justify-content-center">
                <?php for ($i = 0; $i < $limit_members; $i++) { ?>
                    <div class="box<?= $i ?> box border d-none bg-dark" data-id="<?= $i ?>">
                        <div class="content-video" id="video-source<?= $i ?>">
                            <h1 class="text-light username-on-call">Nickname <?= $i ?></h1>

                            <div class="control-owner d-flex ">
                                <?php if ($is_owner && $i > 0) { ?>
                                    <button onclick="muteMember(<?= $i ?>)" class="btn btn-default btn-mute text-white">Mute</button>
                                <?php } ?>
                                <button onclick="pinMember(<?= $i ?>)" class="btn btn-default btn-pin text-white">Pin</button>
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

    if (!$is_owner) : ?>
        <? if (!$request || $request->status != RoomRequest::STATUS_ALLOW) : ?>
            <div class="row">
                <div class="d-flex w-100 border-bottom">
                    <div class="d-flex mr-auto justify-content-start">
                        <h1 class="display-5">Waiting room</h1>
                    </div>
                    <div class="d-flex p-1 justify-content-end"><span class="pt-3"><a href="/site/index" class="text-reset text-decoration-none">Back home <i class="fa fa-times" aria-hidden="true"></i></a></span></div>
                </div>
            </div>
            <div class="row mt-5">
                <div class=" d-flex w-100 justify-content-center">
                    <div class="d-flex w-auto">
                        <?= ImageSlider::widget(['images' => ['https://images.unsplash.com/photo-1507413245164-6160d8298b31?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1050&q=80', 'https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=634&q=80',  'https://images.unsplash.com/photo-1530210124550-912dc1381cb8?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80', 'https://images.unsplash.com/photo-1582719471137-c3967ffb1c42?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=707&q=80']]); ?>
                    </div>
                </div>
            </div>
        <? endif ?>
        <div class="row pt-5">
            <? if (!$request || $request->attempts == 0) : ?>
                <?= Html::submitButton('Join', ['class' => 'btn btn-primary', 'id' => 'btnJoin']) ?>
            <? else : ?>
                <?
                echo match ($request->status) {
                    RoomRequest::STATUS_PENDING =>
                    '<p class="text-info">Your join request is waiting for approval.</p>',
                    RoomRequest::STATUS_DENY =>
                    '<p class="text-danger">Your join request has been denied.</p>' .
                        ($request->attempts < RoomRequest::MAX_ATTEMPTS ? Html::submitButton('Ask for join again', ['class' => 'btn btn-primary', 'id' => 'btnJoin']) : null)
                };
                ?>
        </div>
<? endif;
        endif;
        Pjax::end();
?>

</div><!-- room -->