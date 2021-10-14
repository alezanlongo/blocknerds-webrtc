<?php

namespace frontend\assets\adminlte;

class AdminLteAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/adminlte';
    public $css = [
        'css/adminlte.css',
        'css/dark/adminlte-dark-addon.css',
        'lib/overlayscrollbars/css/OverlayScrollbars.min.css',
        'lib/@fortawesome/fontawesome-free/css/all.min.css'
    ];

    public $js = [
        'js/adminlte.js',
        'lib/overlayscrollbars/js/jquery.overlayScrollbars.min.js',
    ];
   
    // public $publishOptions = [
    //     'forceCopy' => true,
    // ];
}
