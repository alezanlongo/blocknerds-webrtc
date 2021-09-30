<?php

use yii\web\View;

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/rtc-diagnostics.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/test.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);

?>

<div class="container">
    <div class="row">
        <div class="col" id="testAudioVideoDevices">
            <h1>Diagnostics</h1>
            <p>Checks your browser and network environment to ensure you can use WebRTC products.</p>
        </div>
    </div>

    <div class="row">
        <div class="col text-secondary" id="testAudioOutputDevice">
            <h4>Audio output device test </h4>
            <p>Tests audio output capabilities. It serves to help diagnose potential audio device issues that would prevent a user from being able to hear audio.</p>
        </div>
    </div>
    <div class="row">
        <div class="col text-secondary" id="testAudioInputDevice">
            <h4>Audio input device test </h4>
            <p>Tests audio input capabilities. It serves to help diagnose potential audio device issues that would prevent audio from being recognized in a WebRTC call.</p>
        </div>
    </div>
    <div class="row">
        <div class="col text-secondary" id="testVideoInputDevice">
            <h4>Video input device test </h4>
            <p>This test examines video input capabilities. It serves to help diagnose potential video device issues that would prevent video from being shared in a WebRTC call.</p>
            <video id="video-test" width="320" height="240" autoplay class="d-none"></video>
        </div>
    </div>
    <div class="row">
        <div class="col text-secondary" id="testMediaConnectionBitrate">
            <h4>Media connection bitrate test </h4>
            <p>The test uses two RTCPeerConnections connected via a Twilio TURN server. Using RTCDataChannel, one RTCPeerConnection will saturate the data channel buffer and will constantly send data packets to the other RTCPeerConnection. The receiving peer will measure the bitrate base on the amount of packets received every second.</p>
        </div>
    </div>
</div>