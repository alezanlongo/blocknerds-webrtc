<?php

namespace frontend\assets\Janus;

class JanusTextRoom extends \yii\web\AssetBundle
{

    public $sourcePath = '@frontend/assets/Janus';
    public $css = [
        'css/demo.css'
    ];
    public $js = [
        'js/textroom.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
}
