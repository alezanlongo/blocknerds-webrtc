<?php

use yii\web\View;
use yii\helpers\Html;
use frontend\assets\pahoMqtt\PahoMqttAsset;

$this->registerAssetBundle(PahoMqttAsset::class);

$this->registerJsVar('myToken', $myToken, View::POS_END);
$this->registerJsVar('csrf', $csrf, View::POS_END);
$this->registerJsVar('profile_id', $profile_id, View::POS_END);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/mqttChatTestHandler.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);
?>
<h1>chat Test</h1>

<div class="row">
    <div class="col-md-4">
        <!-- DIRECT CHAT PRIMARY -->
        <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-header with-border">
                <h3 class="box-title">One to one message</h3>
                <div class="box-tools pull-right">
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages oneToOne">
                </div>
                <!--/.direct-chat-messages-->
            </div><!-- /.box-body -->
            <div class="box-footer">
                <form action="#" method="post">
                    <input type="text" name="to1" placeholder="To..." class="form-control">
                    <div class="input-group">
                        <input type="text" name="message1" placeholder="Type Message ..." class="form-control message">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat btn1">Send</button>
                        </span>
                    </div>
                </form>
            </div><!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
    <div class="col-md-4">
        <!-- DIRECT CHAT PRIMARY -->
        <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-header with-border">
                <h3 class="box-title">One to one message in a room</h3>
                <div class="box-tools pull-right">
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages oneToOneRoom">
                </div>
                <!--/.direct-chat-messages-->
            </div><!-- /.box-body -->
            <div class="box-footer">
                <form action="#" method="post">
                    <input type="text" name="to2" placeholder="To..." class="form-control">
                    <input type="text" name="room2" placeholder="Room..." class="form-control">
                    <div class="input-group">
                        <input type="text" name="message2" placeholder="Type Message ..." class="form-control message">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat btn2">Send</button>
                        </span>
                    </div>
                </form>
            </div><!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
    <div class="col-md-4">
        <!-- DIRECT CHAT PRIMARY -->
        <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Message to a room</h3>
                <div class="box-tools pull-right">
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages oneToRoom">
                </div>
                <!--/.direct-chat-messages-->
            </div><!-- /.box-body -->
            <div class="box-footer">
                <form action="#" method="post">
                    <input type="text" name="room3" placeholder="Room..." class="form-control">
                    <div class="input-group">
                        <input type="text" name="message3" placeholder="Type Message ..." class="form-control message">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat btn3">Send</button>
                        </span>
                    </div>
                </form>
            </div><!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
</div>