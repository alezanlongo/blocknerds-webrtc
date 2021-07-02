<?php

namespace frontend\assets\Janus;

/**
 * Description of JanusAsset
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class JanusAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@frontend/assets/Janus';
    public $css = [
    ];
    public $js = [
        'js/janus.js'
    ];
    public $depends = [
    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];

}
