<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property inline_response_200_1_body_user $user
 */
class inline_response_200_1_bodyApi extends BaseApiModel
{

    public $user;

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
