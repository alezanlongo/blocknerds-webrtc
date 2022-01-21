<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property object $user
 */
class user_getApi extends BaseApiModel
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
