<?php

namespace common\widgets\gallery;

use yii\web\AssetBundle;

class GalleryWidgetAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/gallery/assets';

    public $js = [
        'js/main.js',
    ];

    public $css = [
        'css/main.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}
