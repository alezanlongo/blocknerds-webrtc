<?php

use frontend\assets\Janus\JanusAsset;
use frontend\assets\Janus\JanusVideoRoomAsset;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */

JanusAsset::register($this);
JanusVideoRoomAsset::register($this);

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

$this->title = 'Plugin Demo: Video Room';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Plugin Demo: Video Room
                    <button class="btn btn-default" autocomplete="off" id="start">Start</button>
                </h1>
            </div>
            <div class="container" id="details">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Demo details</h3>
                        <p>This demo is an example of how you can use the Video Room plugin to
                            implement a simple videoconferencing application. In particular, this
                            demo page allows you to have up to 6 active participants at the same time:
                            more participants joining the room will be instead just passive users.
                            No mixing is involved: all media are just relayed in a publisher/subscriber
                            approach. This means that the plugin acts as a SFU (Selective Forwarding Unit)
                            rather than an MCU (Multipoint Control Unit).</p>
                        <p>If you're interested in testing how simulcasting can be used within
                            the context of a videoconferencing application, just pass the
                            <code>?simulcast=true</code> query string to the url of this page and
                            reload it. If you're using a browser that does support simulcasting
                            (Chrome or Firefox) and the room is configured to use VP8, you'll
                            send multiple qualities of the video you're capturing. Notice that
                            simulcasting will only occur if the browser thinks there is enough
                            bandwidth, so you'll have to play with the Bandwidth selector to
                            increase it. New buttons to play with the feature will automatically
                            appear for viewers when receiving any simulcasted stream. Notice that
                            no simulcast support is needed for watching, only for publishing.
                        </p>
                        <p>To use the demo, just insert a username to join the default room that
                            is configured. This will add you to the list of participants, and allow
                            you to automatically send your audio/video frames and receive the other
                            participants' feeds. The other participants will appear in separate
                            panels, whose title will be the names they chose when registering at
                            the demo.</p>
                        <p>Press the <code>Start</code> button above to launch the demo.</p>
                    </div>
                </div>
            </div>
            <div class="container hide" id="videojoin">
                <div class="row">
                    <span class="label label-info" id="you"></span>
                    <div class="col-md-12" id="controls">
                        <div class="input-group margin-bottom-md hide" id="registernow">
                            <span class="input-group-addon">@</span>
                            <input autocomplete="off" class="form-control" type="text" placeholder="Choose a display name" id="username" onkeypress="return checkEnter(this, event);" />
                            <span class="input-group-btn">
                                <button class="btn btn-success" autocomplete="off" id="register">Join the room</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container hide" id="videos">
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Local Video <span class="label label-primary hide" id="publisher"></span>
                                    <div class="btn-group btn-group-xs pull-right hide">
                                        <div class="btn-group btn-group-xs">
                                            <button id="bitrateset" autocomplete="off" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                Bandwidth<span class="caret"></span>
                                            </button>
                                            <ul id="bitrate" class="dropdown-menu" role="menu">
                                                <li><a href="#" id="0">No limit</a></li>
                                                <li><a href="#" id="128">Cap to 128kbit</a></li>
                                                <li><a href="#" id="256">Cap to 256kbit</a></li>
                                                <li><a href="#" id="512">Cap to 512kbit</a></li>
                                                <li><a href="#" id="1024">Cap to 1mbit</a></li>
                                                <li><a href="#" id="1500">Cap to 1.5mbit</a></li>
                                                <li><a href="#" id="2000">Cap to 2mbit</a></li>
                                            </ul>
                                        </div>
                                    </div>
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Remote Video #3 <span class="label label-info hide" id="remote3"></span></h3>
                            </div>
                            <div class="panel-body relative" id="videoremote3"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Remote Video #4 <span class="label label-info hide" id="remote4"></span></h3>
                            </div>
                            <div class="panel-body relative" id="videoremote4"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Remote Video #5 <span class="label label-info hide" id="remote5"></span></h3>
                            </div>
                            <div class="panel-body relative" id="videoremote5"></div>
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