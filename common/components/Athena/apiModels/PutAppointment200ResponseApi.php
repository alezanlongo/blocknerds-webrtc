<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
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
 */
class PutAppointment200ResponseApi extends BaseApiModel
{

    public $appointmentid;
    public $appointmentstatus;
    public $appointmenttype;
    public $appointmenttypeid;
    public $chargeentrynotrequired;
    public $chargeentrynotrequiredreason;
    public $claims;
    public $copay;
    public $date;
    public $departmentid;
    public $duration;
    public $encounterid;
    public $encounterprep;
    public $encounterstate;
    public $encounterstatus;
    public $frozenyn;
    public $hl7providerid;
    public $insurances;
    public $patient;
    public $patientappointmenttypename;
    public $patientid;
    public $patientlocationid;
    public $providerid;
    public $referringproviderid;
    public $renderingproviderid;
    public $rescheduledappointmentid;
    public $startcheckin;
    public $starttime;
    public $stopcheckin;
    public $supervisingproviderid;
    public $urgentyn;
    public $useexpectedprocedurecodes;

    public function rules()
    {
        return [
            [['appointmentid', 'appointmentstatus', 'appointmenttype', 'appointmenttypeid', 'chargeentrynotrequired', 'chargeentrynotrequiredreason', 'copay', 'date', 'departmentid', 'encounterid', 'encounterprep', 'encounterstate', 'encounterstatus', 'frozenyn', 'patient', 'patientappointmenttypename', 'patientid', 'patientlocationid', 'providerid', 'rescheduledappointmentid', 'startcheckin', 'starttime', 'stopcheckin', 'urgentyn'], 'trim'],
            [['appointmentid', 'appointmentstatus', 'appointmenttype', 'appointmenttypeid', 'chargeentrynotrequired', 'chargeentrynotrequiredreason', 'copay', 'date', 'departmentid', 'encounterid', 'encounterprep', 'encounterstate', 'encounterstatus', 'frozenyn', 'patient', 'patientappointmenttypename', 'patientid', 'patientlocationid', 'providerid', 'rescheduledappointmentid', 'startcheckin', 'starttime', 'stopcheckin', 'urgentyn'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
