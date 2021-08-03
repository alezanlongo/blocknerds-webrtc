<?php
/* @var $this yii\web\View */

use common\models\Request;
use common\widgets\videoRoom\videoWidget;
use frontend\assets\Janus\JanusAsset;
use yii\web\View;
use yii\helpers\Html;
use yii\widgets\Pjax;
use frontend\assets\pahoMqtt\PahoMqttAsset;
use yii\bootstrap4\Button;
use yii\bootstrap4\Modal;

JanusAsset::register($this);
$this->registerAssetBundle(PahoMqttAsset::class);

// $this->registerJsVar('myroom', $uuid, View::POS_END);
// $this->registerJsVar('username',  Yii::$app->getUser()->getIdentity()->username, View::POS_END);
// $this->registerJsVar('user_id', Yii::$app->getUser()->getId(), View::POS_END);
// $this->registerJsVar('is_owner', $is_owner, View::POS_END);
// $this->registerJsVar('is_allowed', $is_allowed, View::POS_END);

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

$this->title = 'The Room';

?>


<?= videoWidget::widget(
    [
        'members' => $members,
        'myRoom' => $uuid,
        'is_owner' => $is_owner,
        'is_allowed' => $is_allowed,
        ]
) ?>

<? Pjax::begin(['id' => 'room-button', "options" => []]);
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

