<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class AppointmentSlotResponse extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%appointment_slot_responses}}';
    }

    public function rules()
    {
        return [
            [['appointmenttype', 'date', 'frozenyn', 'patientappointmenttypename', 'starttime'], 'trim'],
            [['appointmenttype', 'date', 'frozenyn', 'patientappointmenttypename', 'starttime'], 'string'],
            [['appointmentid', 'appointmenttypeid', 'departmentid', 'duration', 'localproviderid', 'providerid', 'reasonid', 'renderingproviderid', 'validappointmenttypeids', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($appointmentid = ArrayHelper::getValue($apiObject, 'appointmentid')) {
            $this->appointmentid = $appointmentid;
        }
        if($appointmenttype = ArrayHelper::getValue($apiObject, 'appointmenttype')) {
            $this->appointmenttype = $appointmenttype;
        }
        if($appointmenttypeid = ArrayHelper::getValue($apiObject, 'appointmenttypeid')) {
            $this->appointmenttypeid = $appointmenttypeid;
        }
        if($date = ArrayHelper::getValue($apiObject, 'date')) {
            $this->date = $date;
        }
        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($duration = ArrayHelper::getValue($apiObject, 'duration')) {
            $this->duration = $duration;
        }
        if($frozenyn = ArrayHelper::getValue($apiObject, 'frozenyn')) {
            $this->frozenyn = $frozenyn;
        }
        if($localproviderid = ArrayHelper::getValue($apiObject, 'localproviderid')) {
            $this->localproviderid = $localproviderid;
        }
        if($patientappointmenttypename = ArrayHelper::getValue($apiObject, 'patientappointmenttypename')) {
            $this->patientappointmenttypename = $patientappointmenttypename;
        }
        if($providerid = ArrayHelper::getValue($apiObject, 'providerid')) {
            $this->providerid = $providerid;
        }
        if($reasonid = ArrayHelper::getValue($apiObject, 'reasonid')) {
            $this->reasonid = $reasonid;
        }
        if($renderingproviderid = ArrayHelper::getValue($apiObject, 'renderingproviderid')) {
            $this->renderingproviderid = $renderingproviderid;
        }
        if($starttime = ArrayHelper::getValue($apiObject, 'starttime')) {
            $this->starttime = $starttime;
        }
        if($validappointmenttypeids = ArrayHelper::getValue($apiObject, 'validappointmenttypeids')) {
            $this->validappointmenttypeids = $validappointmenttypeids;
        }
        if($externalId = ArrayHelper::getValue($apiObject, 'externalId')) {
            $this->externalId = $externalId;
        }
        if($id = ArrayHelper::getValue($apiObject, 'id')) {
            $this->id = $id;
        }

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
    /* FIXME link doesn't work
    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);

        return $saved;
    }
    */
}
