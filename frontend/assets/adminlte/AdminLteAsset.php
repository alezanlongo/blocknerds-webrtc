<?php

namespace frontend\assets\adminlte;

class AdminLteAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/adminlte';
    public $css = [
        'css/adminlte.css',
        // 'css/adminlte.css.map',
        'css/dark/adminlte-dark-addon.css',
        // 'css/dark/adminlte-dark-addon.css.map',
    ];

    public $js = [
        'js/adminlte.js',
    ];
   
    public $publishOptions = [
        'forceCopy' => true,
    ];
}
