<?php

namespace frontend\widgets\imageSlider;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Description of ImageSlider
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class ImageSlider extends Widget
{

    public $images = [];

    public function init() {
        
    }

    public function run(): string {
        ImageSliderAsset::register($this->getView());
        return $this->render('_slider', ['images' => $this->images]);
    }

}
