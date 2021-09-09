<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property string $patientstatusname The patient status name
 * @property int $patientstatusid The patient status ID.
 */
class PatientStatusApi extends Model
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
