<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $errormessage If there was an error with this call and SUCCESS is set to false, this field may provide additional information.
 * @property string $success Returns true if the update was a success.
 */
class LabResultSuccessProcessApi extends BaseApiModel
{

    public $errormessage;
    public $success;

    public function rules()
    {
        return [
            [['errormessage', 'success'], 'trim'],
            [['errormessage', 'success'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
