<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $patientstatusname The patient status name
 * @property int $patientstatusid The patient status ID.
 */
class PatientStatusApi extends BaseApiModel
{

    public $patientstatusname;
    public $patientstatusid;

    public function rules()
    {
        return [
            [['patientstatusname'], 'trim'],
            [['patientstatusname'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
