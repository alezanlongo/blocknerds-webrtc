<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property int $profile_id
 * @property int $model
 * @property sleep_get_series[] $series
 */
class sleep_getApi extends BaseApiModel
{

    public $profile_id;
    public $model;
    public $series;
 
    protected $_seriesAr;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->series) && is_array($this->series)) {
            foreach($this->series as $series) {
                $this->_seriesAr[] = new sleep_get_seriesApi($series);
            }
            $this->series = $this->_seriesAr;
            $this->_seriesAr = [];//CHECKME
        }
    }

}
