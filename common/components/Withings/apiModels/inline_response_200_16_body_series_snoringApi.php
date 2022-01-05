<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Total snoring time
 *
 * @property int $$timestamp
 */
class inline_response_200_16_body_series_snoringApi extends BaseApiModel
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
