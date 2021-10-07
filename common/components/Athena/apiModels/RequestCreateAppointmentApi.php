<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $appointmentdate The appointment date for the new open appointment slot (mm/dd/yyyy).
 * @property array $appointmenttime The time (hh24:mi) for the new appointment slot.  Multiple times (either as a comma delimited list or multiple POSTed values) are allowed.  24 hour time.
 * @property int $appointmenttypeid The appointment type ID to be created.  Either this or a reason must be provided.
 * @property int $departmentid The athenaNet department ID.
 * @property int $providerid The athenaNet provider ID.
 * @property int $reasonid The appointment reason (/patientappointmentreasons) to be created. Either this or a raw appointment type ID must be provided.
 */
class RequestCreateAppointmentApi extends BaseApiModel
{

    public $appointmentdate;
    public $appointmenttime;
    public $appointmenttypeid;
    public $departmentid;
    public $providerid;
    public $reasonid;

    public function rules()
    {
        return [
            [['appointmentdate'], 'trim'],
            [['appointmentdate', 'appointmenttime', 'departmentid', 'providerid'], 'required'],
            [['appointmentdate'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
