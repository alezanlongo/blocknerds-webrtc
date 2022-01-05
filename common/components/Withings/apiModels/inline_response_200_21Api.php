<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $status Response status. See <a href='#section/Response-status'>Status</a> section for details.
 * @property inline_response_200_21_body $body Response data.
 */
class inline_response_200_21Api extends BaseApiModel
{

    public $status;
    public $body;

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
