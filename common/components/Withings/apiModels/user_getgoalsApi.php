<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property object $goals
 */
class user_getgoalsApi extends BaseApiModel
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
