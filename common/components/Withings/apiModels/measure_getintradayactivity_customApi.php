<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use yii\helpers\VarDumper;

/**
 * Response data.
 * 
 * @property Series[] $series
 */
class measure_getintradayactivity_customApi extends measure_getintradayactivityApi
{
    public $series;
    private $_seriesAr;

    public function init()
    {
        if (!empty($this->series) && is_array($this->series)) {
            foreach ($this->series as $key => $value) {
                $value['timestamp'] = $key;
                $this->_seriesAr[] = new measure_getintradayactivityApi($value);
            }

            $this->series = $this->_seriesAr;

            $this->_seriesAr = []; //CHECKME
        }
    }
}
