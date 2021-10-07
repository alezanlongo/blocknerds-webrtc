<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $errormessage If the operation failed, this will contain an error message.
 * @property int $patientcaseid The document ID of the new or modified document.
 * @property string $success Returns true/false if the operation was successful.
 */
class PostPatientCase200ResponseApi extends BaseApiModel
{

    public $errormessage;
    public $patientcaseid;
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
