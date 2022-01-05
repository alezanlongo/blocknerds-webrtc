<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property inline_response_200_21_body_goals $goals
 */
class inline_response_200_21_bodyApi extends BaseApiModel
{

    public $goals;

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
