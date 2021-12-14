<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $patientid The athena ID of the patient whose privacy information was verified.
 * @property string $success Returns true/false if the operation was successful.
 */
class PrivacyInformationVerified200ResponseApi extends BaseApiModel
{

    public $patientid;
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
