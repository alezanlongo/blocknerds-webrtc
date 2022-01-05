<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property inline_response_200_13_body_series_timestamp $$timestamp $timestamp represents the epoch value of the intraday data
 */
class inline_response_200_13_body_seriesApi extends BaseApiModel
{

    public $$timestamp;

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
