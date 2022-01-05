<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Respiration Rate. *(Use 'data_fields' to request this data.)*
 *
 * @property int $$timestamp $timestamp represents the epoch value of the respiration rate data, value of this key will be the respiration rate data
 */
class inline_response_200_16_body_series_rrApi extends BaseApiModel
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
