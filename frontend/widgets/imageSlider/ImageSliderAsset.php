<?php

namespace frontend\widgets\imageSlider;

use yii\web\AssetBundle;

/**
 * Description of ImageSliderAsset
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class ImageSliderAsset extends AssetBundle
{

    public $js = [
        'js/image-slider.js'
    ];
    public $css = [
        'css/image-slider.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public function init() {
        $this->sourcePath = __DIR__ . "/assets";
        parent::init();
    }

    public $publishOptions = [
    //    'forceCopy' => true,
    ];


}
