<?php

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap5\Modal;
use common\models\RoomRequest;
use frontend\assets\room\RoomAsset;
use frontend\assets\Janus\JanusAsset;
use frontend\assets\pahoMqtt\PahoMqttAsset;
use frontend\widgets\imageSlider\ImageSlider;
use yii\helpers\Url;
use yii\helpers\VarDumper;
/** @var boolean $limit_members Whether to limit members for this room...? */

/** @var \yii\web\View $this */
JanusAsset::register($this);
$this->registerAssetBundle(PahoMqttAsset::class);
$this->registerAssetBundle(RoomAsset::class);

$this->registerJsVar('limitMembers', $limit_members, View::POS_END);
$this->registerJsVar('own_mute_audio', $own_mute_audio, View::POS_END);
$this->registerJsVar('own_mute_video', $own_mute_video, View::POS_END);
$this->registerJsVar('countRequest', count($requests), View::POS_END);
$this->registerJsVar('myRoom', $uuid, View::POS_END);
$this->registerJsVar('username',  Yii::$app->getUser()->getIdentity()->username, View::POS_END);
$this->registerJsVar('userProfileId', $user_profile_id, View::POS_END);
$this->registerJsVar('isOwner', $is_owner, View::POS_BEGIN);
$this->registerJsVar('isAllowed', $is_allowed, View::POS_END);
$this->registerJsVar('mytoken', $token, View::POS_END);
$this->registerJsVar('endTime', $endTime, View::POS_END);
$this->registerJsVar('members', $members, View::POS_END);
$this->registerJsVar('irmStatus', $in_room_members_source_status, View::POS_END);

$config = [
    'janus' => [
        // 'protocol'        => \Yii::$app->params['janus.protocol'],
        // 'host'            => \Yii::$app->params['janus.host'],
        'port'            => \Yii::$app->params['janus.port'],
        'path'            => \Yii::$app->params['janus.path'],
        'secret'          => \Yii::$app->params['janus.secret'],
        'adminPath'       => \Yii::$app->params['janus.adminPath'],
        'adminSecret'     => \Yii::$app->params['janus.adminSecret'],
        'adminKey'        => \Yii::$app->params['janus.adminKey'],
        'tokenAuthSecret' => \Yii::$app->params['janus.tokenAuthSecret'],
        'storedAuth'      => \Yii::$app->params['janus.storedAuth'],
        'record'          => \Yii::$app->params['janus.record'],
    ],
    'mqtt'  => [
        'protocol' => \Yii::$app->params['mqtt.protocol'],
        'host'     => \Yii::$app->params['mqtt.host'],
        'port'     => \Yii::$app->params['mqtt.port'],
        'path'     => \Yii::$app->params['mqtt.path'],
    ]
];
$this->registerJs(
    "var roomConfig = ".\yii\helpers\Json::htmlEncode($config).";",
    View::POS_HEAD,
    'roomConfig'
);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/mqttHandler.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);
//$this->registerJsFile(
//    Yii::$app->request->BaseUrl . '/js/countdown.js',
//    [
//        'depends' => "yii\web\JqueryAsset",
//        'position' => View::POS_END
//    ]
//);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/room.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);
$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/boxesHandler.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);

$countdown = <<<'COUNTDOWN'
const handleCountdown = (endTime) => {
  const MILLISECONDS_STRING = "milliseconds";
  const eventTimeFinish = moment(endTime);
  const currentTime = moment();
  let diffTime = eventTimeFinish._i - currentTime.unix();
  let duration = moment.duration(diffTime * 1000, MILLISECONDS_STRING);
  const interval = 1000;

  setInterval(() => {
    duration = moment.duration(duration - interval, MILLISECONDS_STRING);
    if (duration.seconds() < 0) $(".spanCountdown").addClass('text-danger')
    $(".spanCountdown").text(
        checkAddZero(duration.hours()) +
        ":" +
        checkAddZero(duration.minutes()) +
        ":" +
        checkAddZero(duration.seconds())
    );
  }, interval);
};

const checkAddZero = (value) => {
  value = Math.abs(value);
  return value < 10 ? `0${value}` : `${value}`;
};

const switchSignal = (seconds) => {
  if (seconds < 0) return "+ ";
  if (seconds > 0) return "- ";
  return "";
};
COUNTDOWN;

$this->registerJs($countdown, View::POS_END,'countdown_script');


$this->title = 'The Room';

// VarDumper::dump( count($members), $depth = 10, $highlight = true);
// die;
?>

<?php if ($is_owner || ($request && $request->status === RoomRequest::STATUS_ALLOW)) : ?>
    <div class="header-nav fix-top pb-0 ">
        <div class=" flex-grow-1 text-center">
            <span class="spanCountdown h4"></span>
        </div>
        <div class="options-tab">
            <ul class="nav nav-pills mb-3 " id="pills-tab" role="tablist">
                <li class="nav-item option-side" role="presentation" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Settings">
                    <button class="nav-link" id="pills-settings-tab" data-bs-toggle="pill" data-bs-target="#pills-settings" role="tab" aria-controls="pills-settings" aria-selected="true" style="z-index: 9;"><i class="fas fa-cog icon-menu" style="z-index: 0;"></i></button>
                </li>
                <li class="nav-item option-side" role="presentation" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Participant">
                    <button class="nav-link" id="pills-attendees-tab" data-bs-toggle="pill" data-bs-target="#pills-attendees" role="tab" aria-controls="pills-attendees" aria-selected="false" style="z-index: 9;"><i class="fas fa-users icon-menu" style="z-index: 0;"></i></button>
                </li>
                <li class="nav-item option-side" role="presentation" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Chat">
                    <button class="nav-link" id="pills-chat-tab" data-bs-toggle="pill" data-bs-target="#pills-chat" role="tab" aria-controls="pills-chat" aria-selected="false" style="z-index: 9;"><i class="fas fa-comments icon-menu" style="z-index: 0;"></i></button>
                </li>
                <li class="nav-item ml-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Toggle audio">
                    <?= Html::tag('button', '<i class="fas fa-microphone icon-menu"></i>', [
                        'id' => "mute",
                        "class" => "btn btn-link text-white",
                        'onclick' => "toggleMute()"
                    ]) ?>
                </li>
                <li class="nav-item ml-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Toggle video">
                    <?= Html::tag('button', '<i class="fas fa-video icon-menu"></i>', [
                        'id' => "no-video",
                        "class" => "btn btn-link text-white",
                        'onclick' => "toggleVideo()"
                    ]) ?>
                </li>
                <li class="nav-item ml-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Leave">
                    <?= Html::tag('button', 'Leave', ["class" => "btn btn-danger btn-leave"]) ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-content d-flex">
        <?php if ($is_owner || $is_allowed) { ?>
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
            <div class="boxes">
                <div class=" box0 box-preview" data-id="0">
                    <div class="card" style="background-color: transparent !important;">
                        <div class="content-video card-body p-0" id="video-source0">
                            <div class="video-mute-icon d-none ">
                                <i class="fa fa-microphone-slash" aria-hidden="true"></i>
                            </div>
                            <img src="/img/default-user.png" alt="" width="100%" height="100%" id="img0" class="img-profile-preview d-none">
                            <span class="text-light username-on-call"> </span>
                        </div>
                    </div>
                </div>
                <div id="containerBoxes">
                    <?php for ($i = 1; $i < $limit_members; $i++) { ?>
                        <div id="box-<?= $i ?>" class="box<?= $i ?> box d-none" data-id="<?= $i ?>">
                            <div class="card w-100 h-100" style="background-color: transparent !important;">
                                <div class="content-video card-body p-0" id="video-source<?= $i ?>">
                                    <div class="video-mute-icon d-none ">
                                        <i class="fa fa-microphone-slash" aria-hidden="true"></i>
                                    </div>
                                    <div class="video-fullscreen-container" id="participant-fullscreen" aria-hidden="true">
                                        <span id="fullscreen_<?= $i ?>" onclick="fullScreenBehavior(<?= $i ?>)">
                                            <i class="fa fa-expand"></i>
                                        </span>
                                    </div>

                                    <img src="/img/default-user.png" alt="" width="100%" height="100%" id="img<?= $i ?>" class="img-profile-preview d-none">
                                    <span class="text-light username-on-call"> </span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <div class="tab-content sidebar" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-settings" role="tabpanel" aria-labelledby="pills-settings-tab">
                <?= Html::tag('h3', 'Settings section', ['class' => 'text-center']) ?>
            </div>
            <div class="tab-pane fade" id="pills-attendees" role="tabpanel" aria-labelledby="pills-attendees-tab">
                <?= Html::tag('h3', 'Participants', ['class' => 'text-center']) ?>

                <ul class="list-group bg-dark list-attendees">
                    <li class="list-group-item list-group-item-light bg-dark position-relative" data-user-id="<?= Yii::$app->getUser()->getId() ?>" data-index="0">
                        <span class="p-1 username-member text-success" ><?= Yii::$app->getUser()->getIdentity()->username ?> (myself)</span>
                    </li>
                    <?php for ($i = 1; $i < $limit_members; $i++) { 
                        $member = (count($members) > $i) ? $members[$i] : null;
                        ?>
                        <li class="list-group-item list-group-item-light bg-dark position-relative <?= ($member) ? 'profile_id_'.$member['id'] : 'd-none' ?>" id="attendee_<?= $i ?>" data-index="<?= $i ?>">
                            <span class="p-1 username-member usernameFeed<?= $i ?>"><?= ($member) ? $member['username'] : '' ?></span>
                            <?php if ($is_owner) { ?>
                                <div class="position-absolute pt-1 top-0 end-0 member-controls d-none">
                                    <button class="btn btn-link text-light btn-remote-mute" onclick="moderateAudioToggle(this,<?= $i ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Mute/Unmute member audio">
                                        <i class="fas fa-microphone icon-option-member"></i></button> |
                                    <button class="btn btn-link text-light btn-remote-video" onclick="moderateVideoToggle(this,<?= $i ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Mute/Unmute member video">
                                        <i class="fas fa-video icon-option-member"></i></button> |
                                    <button class="btn btn-link text-light btn-remote-kick" data-bs-toggle="tooltip" data-bs-placement="top" title="Kick member">
                                        <i class="fas fa-user-times icon-option-member"></i></button>
                                </div>
                            <?php } ?>
                        </li>
                    <?php  } ?>
                </ul>
            </div>
            <div class="tab-pane fade" id="pills-chat" role="tabpanel" aria-labelledby="pills-chat-tab">
                <?= Html::tag('h3', 'Chat section', ['class' => 'text-center']) ?>
            </div>
        </div>

    </div>
<?php endif ?>

<?php Pjax::begin(['id' => 'room-member', "options" => ['class' => 'container']]);
if (!$is_owner) : ?>
    <?php if (!$request || $request->status !== RoomRequest::STATUS_ALLOW) : ?>
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
            <?php
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
    <?php endif ?>
<?php endif;
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

<?php Modal::begin([
    'title' => 'Require to join...',
    'id' => 'pendingRequests',
    // 'size' => Modal::SIZE_LARGE,
    'closeButton' => false,
    'options' => [
        'data-bs-backdrop' => "static",
        'data-bs-keyboard' => "false",
        'class'=> 'mt-5 pt-3',
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
                    <?php
                    echo Html::submitButton('Allow to join', ['class' => 'btn btn-success', 'id' => 'btnAllow', 'data-user' => $request->user_profile_id]);
                    echo Html::submitButton('Deny to join', ['class' => 'btn btn-danger', 'id' => 'btnDeny', 'data-user' => $request->user_profile_id]);
                    ?>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<script>if (window.jQuery) $('#pendingRequests').modal('hide');</script>";
        echo "<p class='text-info'>Well done, nothing to do here!.<p>";
    }
}
Pjax::end();

Modal::end();
?>