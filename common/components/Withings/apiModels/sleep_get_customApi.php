<?php

namespace common\components\Withings\apiModels;

use Yii;
use yii\helpers\VarDumper;
use common\models\ApiModel as BaseApiModel;
use common\components\Withings\models\sleep_get_series;
use common\components\Withings\models\sleep_get_series_hr;

/**
 * Response data.
 * 
 * @property Series[] $series
 */
class sleep_get_customApi extends sleep_getApi
{
    public $series;
    protected $_seriesAr;

    public function init()
    {
        if (!empty($this->series) && is_array($this->series)) {
            foreach ($this->series as $serie) {

                $serie = $this->buildMeasure($serie, 'hr');
                $serie = $this->buildMeasure($serie, 'rr');
                $serie = $this->buildMeasure($serie, 'snoring');

                $this->_seriesAr[] = new sleep_get_seriesApi($serie);
            }

            $this->series = $this->_seriesAr;

            $this->_seriesAr = []; //CHECKME
        }
    }

    private function buildMeasure($serie, $name)
    {
        if (!empty($serie[$name]) && is_array($serie[$name])) {
            ${$name} = [];
            foreach ($serie[$name] as $key => $value) {
                ${$name}[] = [
                    'timestamp' => $key, 
                    'value' => $value];
            }
            unset($serie[$name]);
            $serie[$name] = ${$name};
        }

        return $serie;
    }
}
