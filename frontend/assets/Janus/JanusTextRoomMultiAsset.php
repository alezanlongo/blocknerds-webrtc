<?php

namespace frontend\assets\Janus;

class JanusTextRoomMultiAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@frontend/assets/Janus';
    public $css = [
        'css/demo.css'
    ];
    public $js = [
        'js/textroommulti.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];
}
