<?php

namespace frontend\assets\users;

class UserProfileAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/users';
    public $css = [
        'css/main.css',
    ];

    public $js = [
        'js/profile.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
}
