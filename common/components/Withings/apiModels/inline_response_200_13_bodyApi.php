<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property inline_response_200_13_body_series $series
 */
class inline_response_200_13_bodyApi extends BaseApiModel
{

    public $series;

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
