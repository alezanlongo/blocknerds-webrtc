<?php
/* @var $this yii\web\View */

use common\models\Member;
use frontend\assets\Janus\JanusAsset;
use yii\web\View;
use yii\helpers\Html;
use yii\widgets\Pjax;
use frontend\assets\pahoMqtt\PahoMqttAsset;

JanusAsset::register($this);
$this->registerAssetBundle(PahoMqttAsset::class);

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

    <h1><?= $this->title ?></h1>

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
        </div>
    <? } ?>

    <?
    Pjax::begin(['id' => 'join-room', "options" => []]);
    if ($is_owner) {
        foreach ($requests as $request) {
    ?>
            <div class="row">
                <div class="card mb-3">
                    <div class="card-header">Require to join...</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $request->user->username ?> wants to join the room</h5>
                        <?
                        echo Html::submitButton('Allow to join', ['class' => 'btn btn-success', 'id' => 'btnAllow', 'data-user' => $request->user_id]);
                        echo Html::submitButton('Deny to join', ['class' => 'btn btn-danger', 'id' => 'btnDeny', 'data-user' => $request->user_id]);
                        ?>
                    </div>
                </div>
            </div>
    <?
        }
    } else {
        if (is_null($status)) {
            echo Html::submitButton('Join', ['class' => 'btn btn-primary', 'id' => 'btnJoin']);
        } else {
            if ($status == Member::STATUS_DENY) {
                echo "<p class='text-danger'>Your join request has been denied.<p>";
            } else if ($status == Member::STATUS_ALLOW) {
                echo "<p class='text-primary'>Welcome to the room!<p>";
            } else {
                echo "<p class='text-info'>Your join request is waiting for approval.<p>";
            }
        }
    }
    Pjax::end();
    ?>

</div><!-- room -->