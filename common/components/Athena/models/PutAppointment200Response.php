<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $appointmentcopay Detailed information about the copay for this appointment.  Gives more detail than the COPAY field.  Note: this information is not yet available in all practices, we are rolling this out slowly.
 * @property string $appointmentid Appointment ID of the booked appointment
 * @property string $appointmentstatus The athenaNet appointment status. There are several possible statuses.  x=cancelled. f=future. (It can include appointments where were never checked in, even if the appointment date is in the past. It is up to a practice to cancel appointments as a no show when appropriate to do so.)  o=open. 2=checked in. 3=checked out. 4=charge entered (i.e. a past appointment).
 * @property string $appointmenttype The practice-friendly (not patient friendly) name for this appointment type.  Note that this may <strong>not</strong> be the same as the booked appointment because of "generic" slots.
 * @property string $appointmenttypeid This is the ID for the appointment type.   Note that this may <strong>not</strong> be the same as the booked appointment because of "generic" slots.
 * @property string $chargeentrynotrequired This field will tell if an appointment has been marked as not requiring change entry.
 * @property string $chargeentrynotrequiredreason This field will give the reason that an appointment has been marked as not requiring charge entry.
 * @property array $claims As detailed in /claims, if requested.
 * @property string $copay Expected copay for this appointment. Based on the appointment type, the patient's primary insurance, and any copays collected.  To see the amounts used in this calculated value, see the APPOINTMENTCOPAY fields.
 * @property string $date The appointment date.
 * @property string $departmentid
 * @property int $duration In minutes
 * @property string $encounterid The encounter id associated with this appointment, useful for certain other calls.  Only present for appointments with Clinicals that have been checked in.
 * @property string $encounterprep If true, encounter prep has been started for the encounter associated with this appointment.
 * @property string $encounterstate The status of the clinical encounter associated with this appointment (OPEN, CLOSED, DELETED, PEND, etc.). This differs from encounterstatus, which refers to the status of the patient in the encounter.
 * @property string $encounterstatus The status of this patient in the encounter (READYFORSTAFF, WITHSTAFF, READFORPROVIDER, CHECKEDOUT).  Only present for appointments with Clinicals that have been checked in.
 * @property string $frozenyn If true, this appointment slot is frozen
 * @property int $hl7providerid This is the raw provider ID that should be used ONLY if using this appointment in conjunction with an HL7 message and with athenahealth's prior guidance. It is only available in some situations.
 * @property array $insurances List of active patient insurance packages. Only shown for single or multiple booked appointments if SHOWINSURANCE is set.
 * @property string $patient As detailed in /patients, if requested.
 * @property string $patientappointmenttypename The patient-friendly name for this appointment type.  Note that this may <strong>not</strong> be the same as the booked appointment because of "generic" slots.
 * @property string $patientid The athenaNet patient ID for this appointment
 * @property string $patientlocationid The location of the patient. See /patientlocation for practice list. Only present for appointments with Clinicals that have been checked in.
 * @property string $providerid
 * @property int $referringproviderid The referring provider ID.
 * @property int $renderingproviderid The rendering provider ID.
 * @property string $rescheduledappointmentid When an appointment is rescheduled, this is the ID of the replacement appointment.
 * @property string $startcheckin The timestamp when the appointment started the check in process. If this is set while an appointment is still in status 'f', it means that the check-in process has begun but is not yet completed.
 * @property string $starttime As HH:MM (where HH is the 0-23 hour and MM is the minute).  This time is local to the department.
 * @property string $stopcheckin The timestamp when the check-in process was finished for this appointment.
 * @property int $supervisingproviderid The supervising provider ID.
 * @property string $urgentyn Urgent flag for the appointment.
 * @property array $useexpectedprocedurecodes An array of expected procedure codes attached to this appointment.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PutAppointment200Response extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%put_appointment200_responses}}';
    }

    public function rules()
    {
        return [
            [['appointmentcopay', 'appointmentid', 'appointmentstatus', 'appointmenttype', 'appointmenttypeid', 'chargeentrynotrequired', 'chargeentrynotrequiredreason', 'copay', 'date', 'departmentid', 'encounterid', 'encounterprep', 'encounterstate', 'encounterstatus', 'frozenyn', 'patient', 'patientappointmenttypename', 'patientid', 'patientlocationid', 'providerid', 'rescheduledappointmentid', 'startcheckin', 'starttime', 'stopcheckin', 'urgentyn'], 'trim'],
            [['appointmentcopay', 'appointmentid', 'appointmentstatus', 'appointmenttype', 'appointmenttypeid', 'chargeentrynotrequired', 'chargeentrynotrequiredreason', 'copay', 'date', 'departmentid', 'encounterid', 'encounterprep', 'encounterstate', 'encounterstatus', 'frozenyn', 'patient', 'patientappointmenttypename', 'patientid', 'patientlocationid', 'providerid', 'rescheduledappointmentid', 'startcheckin', 'starttime', 'stopcheckin', 'urgentyn'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        $this->appointmentcopay = ArrayHelper::getValue($apiObject, 'appointmentcopay');
        $this->appointmentid = ArrayHelper::getValue($apiObject, 'appointmentid');
        $this->appointmentstatus = ArrayHelper::getValue($apiObject, 'appointmentstatus');
        $this->appointmenttype = ArrayHelper::getValue($apiObject, 'appointmenttype');
        $this->appointmenttypeid = ArrayHelper::getValue($apiObject, 'appointmenttypeid');
        $this->chargeentrynotrequired = ArrayHelper::getValue($apiObject, 'chargeentrynotrequired');
        $this->chargeentrynotrequiredreason = ArrayHelper::getValue($apiObject, 'chargeentrynotrequiredreason');
        $this->claims = ArrayHelper::getValue($apiObject, 'claims');
        $this->copay = ArrayHelper::getValue($apiObject, 'copay');
        $this->date = ArrayHelper::getValue($apiObject, 'date');
        $this->departmentid = ArrayHelper::getValue($apiObject, 'departmentid');
        $this->duration = ArrayHelper::getValue($apiObject, 'duration');
        $this->encounterid = ArrayHelper::getValue($apiObject, 'encounterid');
        $this->encounterprep = ArrayHelper::getValue($apiObject, 'encounterprep');
        $this->encounterstate = ArrayHelper::getValue($apiObject, 'encounterstate');
        $this->encounterstatus = ArrayHelper::getValue($apiObject, 'encounterstatus');
        $this->frozenyn = ArrayHelper::getValue($apiObject, 'frozenyn');
        $this->hl7providerid = ArrayHelper::getValue($apiObject, 'hl7providerid');
        $this->insurances = ArrayHelper::getValue($apiObject, 'insurances');
        $this->patient = ArrayHelper::getValue($apiObject, 'patient');
        $this->patientappointmenttypename = ArrayHelper::getValue($apiObject, 'patientappointmenttypename');
        $this->patientid = ArrayHelper::getValue($apiObject, 'patientid');
        $this->patientlocationid = ArrayHelper::getValue($apiObject, 'patientlocationid');
        $this->providerid = ArrayHelper::getValue($apiObject, 'providerid');
        $this->referringproviderid = ArrayHelper::getValue($apiObject, 'referringproviderid');
        $this->renderingproviderid = ArrayHelper::getValue($apiObject, 'renderingproviderid');
        $this->rescheduledappointmentid = ArrayHelper::getValue($apiObject, 'rescheduledappointmentid');
        $this->startcheckin = ArrayHelper::getValue($apiObject, 'startcheckin');
        $this->starttime = ArrayHelper::getValue($apiObject, 'starttime');
        $this->stopcheckin = ArrayHelper::getValue($apiObject, 'stopcheckin');
        $this->supervisingproviderid = ArrayHelper::getValue($apiObject, 'supervisingproviderid');
        $this->urgentyn = ArrayHelper::getValue($apiObject, 'urgentyn');
        $this->useexpectedprocedurecodes = ArrayHelper::getValue($apiObject, 'useexpectedprocedurecodes');
        $this->id = ArrayHelper::getValue($apiObject, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
