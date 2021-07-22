<?php

namespace frontend\assets\pahoMqtt;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class PahoMqttAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/pahoMqtt';
    
    public $js = [
        'js/mqttws31.min.js'
    ];
    public $depends = [
        
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
}
