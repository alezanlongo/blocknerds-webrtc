<?php

use frontend\assets\Janus\JanusAsset;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\View;

/* @var $this View */

JanusAsset::register($this);
$this->registerJsVar('myUsername', Yii::$app->getUser()->getIdentity()->username, View::POS_END);
$this->registerJsFile(
    "https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js",
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);
$this->registerJsFile(
    "https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/8.0.0/adapter.min.js",
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);
$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/textroom2.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);

?>


<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h1>Text chat
                <!-- <button class="btn btn-default" autocomplete="off" id="start">Start</button> -->
            </h1>
        </div>

     
        <div class="container hide" id="room" style="display: none;">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Participants <span class="label label-info hide" id="participant"></span></h3>
                        </div>
                        <div class="panel-body">
                            <ul id="list" class="list-group">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Public Chatroom</h3>
                        </div>
                        <div class="panel-body relative" style="overflow-x: auto;" id="chatroom">
                        </div>
                        <div class="panel-footer">
                            <div class="input-group margin-bottom-sm">
                                <span class="input-group-addon"><i class="fa fa-cloud-upload fa-fw"></i></span>
                                <input class="form-control" type="text" placeholder="Write a chatroom message" autocomplete="off" id="datasend" onkeypress="return checkEnter(this, event);" disabled />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>