<?php

use frontend\assets\Janus\JanusAsset;
use frontend\assets\Janus\JanusScreenSharingAsset;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */

JanusAsset::register($this);
JanusScreenSharingAsset::register($this);


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

$this->title = 'Plugin Demo: Screen Sharing';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1><?= Html::encode($this->title) ?>
                    <button class="btn btn-default" autocomplete="off" id="start">Start</button>
                </h1>
            </div>
            <div class="container" id="details">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Demo details</h3>
                        <p>This demo, as the Video Conferencing one, makes use of the Video Room plugin. Unlike
                            the video conferencing scenario, though, this demo implements a webinar kind of scenario:
                            that is, it allows a single user to share their screen with a set of passive
                            viewers.</p>
                        <p>When started, the demo asks you whether you want to be the one sharing the screen
                            (or an application you're using, if your browser version is recent enough)
                            or a viewer to an existing session. When sharing your screen/application, an ID will be returned
                            that you'll be able to share with other people to act as viewers.</p>
                        <div class="alert alert-info"><b>Note well!</b> If you want to share your screen, you may need to open
                            the <b>HTTPS</b> version of this page. If Janus is not behind the same webserver
                            as the pages that are served (that is, you didn't configure a proxying of HTTP requests
                            to Janus via a web frontend, e.g., Apache HTTPD), make sure you started it
                            with HTTPS support as well, since for security reasons you cannot contact an HTTP
                            backend if the page has been served via HTTPS. Besides, if you configured Janus
                            to make use of self-signed certificates, try and open a generic link served by Janus
                            in the browser itself, or otherwise AJAX requests to it will fail due to the unsafe
                            nature of the certificate.</div>
                        <p>Press the <code>Start</code> button above to launch the demo.</p>
                    </div>
                </div>
            </div>
            <div class="container hide" id="screenmenu">
                <div class="row">
                    <div class="input-group margin-bottom-md hide" id="createnow">
                        <span class="input-group-addon"><i class="fa fa-users fa-1"></i></span>
                        <input class="form-control" type="text" placeholder="Insert a title for the session" autocomplete="off" id="desc" onkeypress="return checkEnterShare(this, event);" />
                        <span class="input-group-btn">
                            <button class="btn btn-success" autocomplete="off" id="create">Share your screen</button>
                        </span>
                    </div>
                </div>
                <div class="divider col-md-12">
                    <hr class="pull-left" />or
                    <hr class="pull-right" />
                </div>
                <div class="row">
                    <div class="input-group margin-bottom-md hide" id="joinnow">
                        <span class="input-group-addon"><i class="fa fa-play-circle-o fa-1"></i></span>
                        <input class="form-control" type="text" placeholder="Insert the numeric session identifier" autocomplete="off" id="roomid" onkeypress="return checkEnterJoin(this, event);" />
                        <span class="input-group-btn">
                            <button class="btn btn-success" autocomplete="off" id="join">Join an existing session</button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="container hide" id="room">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Screen Capture <span class="label label-info" id="title"></span> <span class="label label-success" id="session"></span></h3>
                            </div>
                            <div class="panel-body" id="screencapture"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="footer">
    </div>
</div>