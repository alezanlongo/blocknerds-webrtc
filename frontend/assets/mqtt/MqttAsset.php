<?php

namespace frontend\assets\mqtt;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MqttAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/mqtt/js/';
    
    public $js = [
        '4.2.8/mqtt.min.js'
    ];
    public $depends = [
        
    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];
    
}
