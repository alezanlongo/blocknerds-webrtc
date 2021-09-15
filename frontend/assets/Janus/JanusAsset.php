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
        'libs/janus.js',
        'libs/adapter.min.js',
        'libs/jquery.blockUI.min.js',
        'libs/bootbox.min.js',
        'libs/spin.min.js',
        'libs/toastr.min.js',
    ];
    public $depends = [
    	'yii\web\JqueryAsset'
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];

}
