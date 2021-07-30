<?php
/* @var $this yii\web\View */

use common\models\Request;
use frontend\assets\Janus\JanusAsset;
use yii\web\View;
use yii\helpers\Html;
use yii\widgets\Pjax;
use frontend\assets\pahoMqtt\PahoMqttAsset;
use yii\bootstrap4\Button;
use yii\bootstrap4\Modal;

JanusAsset::register($this);
$this->registerAssetBundle(PahoMqttAsset::class);

$this->registerJsVar('myroom', $room_id, View::POS_END);
$this->registerJsVar('uuid', $uuid, View::POS_END);
$this->registerJsVar('username',  Yii::$app->getUser()->getIdentity()->username, View::POS_END);
$this->registerJsVar('user_id', $user_id, View::POS_END);
$this->registerJsVar('is_owner', $is_owner, View::POS_END);
$this->registerJsVar('is_allowed', $is_allowed, View::POS_END);


$this->registerJsFile(
    "https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/8.0.0/adapter.min.js",
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);
$this->registerJsFile(
    "https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js",
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);
$this->registerJsFile(
    "https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js",
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);
$this->registerJsFile(
    "https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js",
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);
$this->registerJsFile(
    "https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js",
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/otherFunctions.js',
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
<div class="room">

    <h1><?= $this->title . " " . $room_id ?></h1>

    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
        ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
        fugiat nulla pariatur.</p>

    <? if ($is_owner || $is_allowed) { ?>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Local Video <span class="label label-primary hide" id="publisher"></span>
                        </h3>
                    </div>
                    <div class="panel-body" id="videolocal"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Remote Video #1 <span class="label label-info hide" id="remote1"></span></h3>
                    </div>
                    <div class="panel-body relative" id="videoremote1"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Remote Video #2 <span class="label label-info hide" id="remote2"></span></h3>
                    </div>
                    <div class="panel-body relative" id="videoremote2"></div>
                </div>
            </div>

        </div>
    <? } ?>

    <?


    Pjax::begin(['id' => 'room-button', "options" => []]);
    if ($is_owner && count($requests) > 0) {
        echo Button::widget([
            'label' => 'Join requests available!',
            "options" => ["class" => "btn-lg btn-info mb-3", "onclick" => "(function ( event ) { $('#pendingRequests').modal('show'); })();"],
        ]);
    }
    Pjax::end();

    Modal::begin([
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
            if ($request->status == Request::STATUS_DENY) {
                echo "<p class='text-danger'>Your join request has been denied.<p>";
                echo $request->attempts < Request::MAX_ATTEMPTS ? Html::submitButton('Ask for join again', ['class' => 'btn btn-primary', 'id' => 'btnJoin']) : null;
            } else if ($request->status == Request::STATUS_ALLOW) {
                echo "<p class='text-primary'>Welcome to the room!<p>";
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