<?php

namespace frontend\assets\MomentJs;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MomentJsAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/MomentJs';

    public $js = [
        'js/moment.min.js'
    ];

    public $depends = [];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}
