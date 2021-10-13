<?php

namespace frontend\assets\adminlte;

class AdminLTEDependencesAssets extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/adminlte';
    public $css = [
        'css/adminlte.css',
        'css/adminlte.css.map',
        'css/dark/adminlte-dark-addon.css',
        'css/dark/adminlte-dark-addon.css.map',
        'adminlte/vendor/@fortawesome/fontawesome-free/css/all.min.css',
        'adminlte/vendor/overlayscrollbars/css/OverlayScrollbars.min.css',
    ];

    public $js = [
        'js/adminlte.js',
        'js/adminlte.js.map',
        'adminlte/vendor/overlayscrollbars/js/jquery.overlayScrollbars.min.js',
        'adminlte/vendor/bootstrap/dist/js/bootstrap.bundle.js',
        'adminlte/vendor/chart.js/dist/chart.js',
        'adminlte/assets/js/dashboard.js',
    ];
    // public $depends = [
    //     'yii\web\JqueryAsset',
    //     'yii\bootstrap5\BootstrapAsset',
    // ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
}
