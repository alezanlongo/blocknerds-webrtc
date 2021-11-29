<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $message If success is false, this contains an error message with more detail.
 * @property string $success True if operation was sucessful, false otherwise.
 */
class PutInsuranceResponseApi extends BaseApiModel
{

    public $message;
    public $success;

    public function rules()
    {
        return [
            [['message', 'success'], 'trim'],
            [['message', 'success'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
