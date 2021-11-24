<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $success Returns if the call to manipulate subscriptions for labresults was successful.
 */
class LabResultSuscriptionSuccessApi extends BaseApiModel
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
