<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $errormessage If the operation failed, this will contain any error messages.
 * @property string $success Whether the operation was successful or not.
 */
class VitalsResponseApi extends BaseApiModel
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
