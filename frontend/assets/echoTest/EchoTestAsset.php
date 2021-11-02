<?php

namespace frontend\assets\echoTest;

class EchoTestAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/echoTest';
    public $css = [
    ];

    public $js = [
        'js/main.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
}
