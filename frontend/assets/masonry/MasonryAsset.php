<?php

namespace frontend\assets\masonry;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MasonryAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/masonry';
    
    public $js = [
        'js/masonry.pkgd.min.js'
    ];
    public $depends = [
        
    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];
    
}
