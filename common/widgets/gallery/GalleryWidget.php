<?php

namespace common\widgets\gallery;

use yii\base\Widget;
use common\widgets\gallery\GalleryWidgetAsset;
use yii\helpers\VarDumper;

class GalleryWidget extends Widget
{

    public $photos = [];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        GalleryWidgetAsset::register($this->getView());

        return $this->render(
            '_gallery',
            [
                'photos' => $this->photos,
            ]
        );
    }
}
