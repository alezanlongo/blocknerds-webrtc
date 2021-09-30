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

<video id="video-test" width="320" height="240" autoplay></video>