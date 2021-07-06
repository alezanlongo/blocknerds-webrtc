<?php

namespace frontend\assets\Janus;

/**
 * Description of JanusScreenSharingAsset
 *
 * @author Nahuel Bulian <nbulian at gmail.com>
 */
class JanusScreenSharingAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@frontend/assets/Janus';
    public $css = [
        'css/demo.css'
    ];
    public $js = [
        'js/screensharingtest.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];
}
