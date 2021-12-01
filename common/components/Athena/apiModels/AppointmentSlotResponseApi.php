<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $appointmentid This is the ID of the appointment to use when booking. To be clear about the behind-the-scenes functionality, this is technically the first ID that will be used. Because of the ability to combine multiple "generic" slots into a single appointment, this may be first ID used. This is important only if trying to reconcile this against a practice's schedule template.
 * @property string $appointmenttype The practice-friendly (not patient friendly) name for this appointment type.  Note that this may <strong>not</strong> be the same as the booked appointment because of "generic" slots.
 * @property int $appointmenttypeid This is the ID for the appointment type.   Note that this may <strong>not</strong> be the same as the booked appointment because of "generic" slots.
 * @property string $date The appointment date.
 * @property int $departmentid The athenaNet department ID for the appointment
 * @property int $duration In minutes
 * @property string $frozenyn If true, this appointment slot is frozen
 * @property int $localproviderid The local athenaNet ID for the provider of the appointment.
 * @property string $patientappointmenttypename The patient-friendly name for this appointment type.  Note that this may <strong>not</strong> be the same as the booked appointment because of "generic" slots.
 * @property int $providerid The athenaNet ID for the provider of the appointment.
 * @property int $reasonid A list of reason IDs that could be used for this slot. Only present if multiple reason IDs are requested.
 * @property int $renderingproviderid The rendering provider ID.
 * @property string $starttime As HH:MM (where HH is the 0-23 hour and MM is the minute).  This time is local to the department.
 * @property int $validappointmenttypeids A list of Appointment Type IDs that are valid to be booked in this slot. This will only be included if "New Schedule Admin" is enabled for the practice.
 */
class AppointmentSlotResponseApi extends BaseApiModel
{

    public $appointmentid;
    public $appointmenttype;
    public $appointmenttypeid;
    public $date;
    public $departmentid;
    public $duration;
    public $frozenyn;
    public $localproviderid;
    public $patientappointmenttypename;
    public $providerid;
    public $reasonid;
    public $renderingproviderid;
    public $starttime;
    public $validappointmenttypeids;

    public function rules()
    {
        return [
            [['appointmenttype', 'date', 'frozenyn', 'patientappointmenttypename', 'starttime'], 'trim'],
            [['appointmenttype', 'date', 'frozenyn', 'patientappointmenttypename', 'starttime'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
