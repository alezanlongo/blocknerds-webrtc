<?php

use PHPUnit\Util\Log\JSON;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/**@var View $this */
$this->registerJs(<<<JS
function hasGetUserMedia() {
  return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
}
if (!hasGetUserMedia()) {
  alert("this video chat is not supported by your browser");
}
JS);
$this->registerCss(<<<CSS
video {
  -webkit-transform: scaleX(-1);
  transform: scaleX(-1);
}
.content-video-wr{
    float: flex
}
.actions-wr{    float: flex
}
CSS)
?>
<h2 class="waiting-room">Waiting room</h2>
    <div class="content-video-wr" id="video-source-wr">
        <video autoplay></video>

        <script>
            const constraints = {
                video: {width:520,height: 200},
            };

            const video = document.querySelector("video");

            navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
                video.srcObject = stream;
            });
        </script>

        <button onclick="muteMember(0)" class="btn btn-default btn-mute text-white">  already in room connected: Admin </button>
        <?= Html::button('Join', ['class' => 'btn btn-primary', 'id' => 'btnJoin']);?>
    </div>
<div class="actions-wr">

</div>