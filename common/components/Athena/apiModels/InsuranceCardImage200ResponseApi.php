<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $success Indicates whether the submission was successful.
 */
class InsuranceCardImage200ResponseApi extends BaseApiModel
{

    public $success;

    public function rules()
    {
        return [
            [['success'], 'trim'],
            [['success'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
