<?php

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\RoomRequest;
use frontend\assets\room\RoomAsset;
use frontend\assets\Janus\JanusAsset;
use frontend\assets\pahoMqtt\PahoMqttAsset;
use frontend\widgets\imageSlider\ImageSlider;
use yii\helpers\Url;


/** @var \yii\web\View $this */
JanusAsset::register($this);
$this->registerAssetBundle(PahoMqttAsset::class);
$this->registerAssetBundle(RoomAsset::class);

$this->registerJsVar('limitMembers', $limit_members, View::POS_END);
$this->registerJsVar('countRequest', count($requests), View::POS_END);
$this->registerJsVar('myRoom', $uuid, View::POS_END);
$this->registerJsVar('username',  Yii::$app->getUser()->getIdentity()->username, View::POS_END);
$this->registerJsVar('userProfileId', $user_profile_id, View::POS_END);
$this->registerJsVar('isOwner', $is_owner, View::POS_END);
$this->registerJsVar('isAllowed', $is_allowed, View::POS_END);
$this->registerJsVar('mytoken', $token, View::POS_END);
$this->registerJsVar('endTime', $endTime, View::POS_END);
$this->registerJsVar('irmStatus', $in_room_members_source_status, View::POS_END);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/mqttHandler.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);
$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/countdown.js',
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

<?php if ($is_owner || ($request && $request->status === RoomRequest::STATUS_ALLOW)) : ?>
    <div class="main-content">
        <div class="header-content d-flex pt-3 pr-3 pl-3 fixed-top">
            <div class=" flex-grow-1 text-center">
                <span class="spanCountdown h4"></span>
            </div>
            <div class="options-tab d-flex ">
                <ul class="nav nav-pills mb-3 " id="pills-tab" role="tablist">
                    <li class="nav-item option-side" role="presentation">
                        <a class="nav-link" id="pills-settings-tab" data-toggle="pill" href="#pills-settings" role="tab" aria-controls="pills-settings" aria-selected="true"><i class="fas fa-cog icon-menu"></i></a>
                    </li>
                    <li class="nav-item option-side" role="presentation">
                        <a class="nav-link" id="pills-attendees-tab" data-toggle="pill" href="#pills-attendees" role="tab" aria-controls="pills-attendees" aria-selected="false"><i class="fas fa-users icon-menu"></i></a>
                    </li>
                    <li class="nav-item option-side" role="presentation">
                        <a class="nav-link" id="pills-chat-tab" data-toggle="pill" href="#pills-chat" role="tab" aria-controls="pills-chat" aria-selected="false"><i class="fas fa-comments icon-menu"></i></a>
                    </li>
                    <li class="nav-item ml-3">
                        <?= Html::tag('button', '<i class="fas fa-microphone icon-menu"></i>', [
                            'id' => "mute",
                            "class" => "btn btn-default text-white",
                            'onclick' => "toggleMute()"
                        ]) ?>
                    </li>
                    <li class="nav-item ml-3">
                        <?= Html::tag('button', '<i class="fas fa-video icon-menu"></i>', [
                            'id' => "no-video",
                            "class" => "btn btn-default text-white",
                            'onclick' => "toggleVideo()"
                        ]) ?>
                    </li>
                    <li class="nav-item ml-3">
                        <?= Html::tag('button', 'Leave', ["class" => "btn btn-danger btn-leave"]) ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="room-content mt-5" id="main">
            <div class="room">
                <? if ($is_owner || $is_allowed) { ?>
                    <div class="join-again d-none">
                        <div class="card">
                            <div class="card-title">
                                <?= Html::tag("h4", "You left of the room") ?>
                            </div>
                            <div class="card-body">
                                <?= Html::tag("button", "Join again",  ["class" => "btn btn-primary btn-join-again"]) ?>
                                <?= Html::a('Go home', ['/'], ['class' => 'btn btn-default text-white']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="room-videos">
                        <div class="wrapper">
                            <?php for ($i = 0; $i < $limit_members; $i++) { ?>
                                <div class="box<?= $i ?> box d-none <?= $i === 0 ? "box-preview" : '' ?>" data-id="<?= $i ?>">
                                    <div class="content-video" id="video-source<?= $i ?>">
                                        <h1 class="text-light username-on-call"> </h1>
                                        <img src="https://www.uic.mx/posgrados/files/2018/05/default-user.png" alt="" width="100%" height="100%" id="img<?= $i ?>" class="img-profile-preview d-none">
                                        <div class="video-mute-icon d-none" style="width: 30px; height:auto; position:absolute"><i class="fa fa-microphone-slash" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <? } ?>
            </div>
            <div class="side-content sidebar" id="optionsSidebar">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade" id="pills-settings" role="tabpanel" aria-labelledby="pills-settings-tab">Settings section</div>
                    <div class="tab-pane fade" id="pills-attendees" role="tabpanel" aria-labelledby="pills-attendees-tab">
                        <?= Html::tag('h3', 'Participants', ['class' => 'text-center']) ?>

                        <ul class="list-group bg-dark list-attendees">
                            <?php Pjax::begin(['id' => 'room-participants-actions', "options" => []]); ?>
                            <?php for ($i = 0; $i < count($in_room_members); $i++) { ?>
                                <li class="list-group-item bg-dark" id="participant_<?= $in_room_members[$i] ?>" data-id="<?= $in_room_members[$i] ?>" data-index="<?= $i ?>">
                                    <span class="p-1 usernameFeed"></span>
                                    <?php if ($is_owner) { ?>
                                        <button class="btn btn-default text-light btn-remote-mute"><i class="fas fa-microphone"></i></button> |
                                        <button class="btn btn-default text-light btn-remote-video"><i class="fas fa-video"></i></button> |
                                        <button class="btn btn-default text-light btn-remote-kick"><i class="fas fa-user-times"></i></button>
                                    <?php } ?>
                                    <span class="p-1 usernameFeed<?= $i ?>"></span>
                                </li>
                            <?php  } ?>
                            <?php Pjax::end(); ?>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="pills-chat" role="tabpanel" aria-labelledby="pills-chat-tab">Chat section</div>
                </div>
            </div>
        </div>
    </div>
<? endif ?>

<?php Pjax::begin(['id' => 'room-member', "options" => ['class' => 'container']]);
if (!$is_owner) : ?>
    <? if (!$request || $request->status !== RoomRequest::STATUS_ALLOW) : ?>
        <div class="row ">
            <div class="d-flex w-100 border-bottom">
                <div class="d-flex mr-auto justify-content-start">
                    <h1 class="display-5">Waiting room</h1>
                </div>
                <div class="d-flex p-1 justify-content-end"><span class="pt-3"><a href="/" class="text-reset text-decoration-none">Back home <i class="fa fa-times" aria-hidden="true"></i></a></span></div>
            </div>
        </div>
        <div class="row mt-5">
            <div class=" d-flex w-100 justify-content-center">
                <div class="d-flex w-auto">
                    <?= ImageSlider::widget(['images' => ['https://images.unsplash.com/photo-1507413245164-6160d8298b31?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1050&q=80', 'https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=634&q=80',  'https://images.unsplash.com/photo-1530210124550-912dc1381cb8?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80', 'https://images.unsplash.com/photo-1582719471137-c3967ffb1c42?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=707&q=80']]); ?>
                </div>
            </div>
        </div>
        <div class="row pt-5">
            <?
            echo match ($request->status ?? null) {
                RoomRequest::STATUS_PENDING =>
                '<p class="text-info">Your join request is waiting for approval.</p>',
                RoomRequest::STATUS_DENY =>
                '<p class="text-danger">Your join request has been denied.</p>' .
                    ($request->attempts < RoomRequest::MAX_ATTEMPTS ? Html::submitButton('Ask for join again', ['class' => 'btn btn-primary', 'id' => 'btnJoin']) : null),
                default => $this->registerJs('joinHandler("request", userProfileId);') //Html::submitButton('Join', ['class' => 'btn btn-primary', 'id' => 'btnJoin'])
            };
            ?>
        </div>
    <? endif ?>
<? endif;
Pjax::end();
?>

<?php Modal::begin([
    'title' => 'Profile information',
    'id' => 'modalInfoUser'
]); ?>
<div class="image-profile text-center">
    <img src="" alt="img-profile" width="150px" height="150px" class="border rounded-circle">
    <i class="fa fa-user-circle icon-profile d-none" aria-hidden="true"></i>
</div>
<div class="info-profile text-center">
    <p class="full-name-profile"></p>
    <p class="nickname-profile"></p>
    <p class="email-profile"></p>
    <p class="phone-profile"></p>
</div>

<?php Modal::end(); ?>

<? Modal::begin([
    'title' => 'Require to join...',
    'id' => 'pendingRequests',
    'options' => [
        'data-backdrop' => "static",
        'data-keyboard' => "false"
    ],
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
                    echo Html::submitButton('Allow to join', ['class' => 'btn btn-success', 'id' => 'btnAllow', 'data-user' => $request->user_profile_id]);
                    echo Html::submitButton('Deny to join', ['class' => 'btn btn-danger', 'id' => 'btnDeny', 'data-user' => $request->user_profile_id]);
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
?>