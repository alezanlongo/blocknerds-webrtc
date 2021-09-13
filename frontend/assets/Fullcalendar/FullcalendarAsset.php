<?php

namespace frontend\assets\Fullcalendar;

/**
 * Description of FullcalendarAsset
 *
 *  */
class FullcalendarAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@frontend/assets/Fullcalendar';
    public $css = [
        'css/jquery.fullcalendar.min.css',
        'css/main.css'
    ];
    public $js = [
        'js/jquery.fullcalendar.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
}
