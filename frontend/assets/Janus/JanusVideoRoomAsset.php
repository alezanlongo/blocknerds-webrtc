<?php

namespace frontend\assets\Janus;

/**
 * Description of JanusVideoRoomAsset
 *
 * @author Nahuel Bulian <nbulian at gmail.com>
 */
class JanusVideoRoomAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@frontend/assets/Janus';
    public $css = [
        'css/demo.css'
    ];
    public $js = [
        'js/videoroomtest.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];
}
