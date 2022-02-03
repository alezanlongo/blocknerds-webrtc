<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $timestamp $timestamp represents the epoch value of the respiration rate data, value of this key will be the respiration rate data
 * @property int $value
 * @property sleep_get_series $sleep_get_series
 */
class sleep_get_series_rrApi extends BaseApiModel
{

    public $timestamp;
    public $value;
    public $sleep_get_series;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
    }

}
