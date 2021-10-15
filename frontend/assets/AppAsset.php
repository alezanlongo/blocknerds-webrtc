<?php

namespace frontend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        // 'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\AdminLTEAssetBundle',
    ];

    // public function init()
    // {
    //     parent::init();
    //     // resetting BootstrapAsset to not load own css files
    //     Yii::$app->assetManager->bundles['yii\\bootstrap4\\BootstrapAsset'] = [
    //         'css' => []
    //     ];
    // }
}
