<?php

namespace frontend\assets\Datetimepicker;

/**
 * Description of DatetimepickerAsset
 *
 *  */
class DatetimepickerAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@frontend/assets/Datetimepicker';
    public $css = [
        'css/jquery.datetimepicker.min.css'
    ];
    public $js = [
        'js/jquery.datetimepicker.full.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
}
