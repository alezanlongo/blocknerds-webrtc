<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $appointmenttypeid The appointment type to be booked.  This field should never be used for booking appointments for web-based scheduling. The use of this field is reserved for digital check-in (aka "kiosk") or an application used by practice staff.  One of this or reasonid is required.
 * @property string $bookingnote A note from the patient about why this appointment is being booked
 * @property int $departmentid The athenaNet department ID.
 * @property bool $donotsendconfirmationemail For clients with athenaCommunicator, certain appointment types can be configured to have an appointment confirmation email sent to the patient at time of appointment booking. If this parameter is set to true, that email will not be sent.  This should only be used if you plan on sending a confirmation email via another method.
 * @property bool $ignoreschedulablepermission By default, we allow booking of appointments marked as schedulable via the web.  This flag allows you to bypass that restriction for booking.
 * @property object $insuranceinfo Patient insurance information, which will be added to the note on the appointment.
 * @property bool $nopatientcase By default, we create a patient case upon booking an appointment for new patients.  Setting this to true bypasses that patient case.
 * @property int $patientid The athenaNet patient ID.
 * @property int $reasonid The appointment reason ID to be booked.  This field is required for booking appointments for web-based scheduling and is a reason that is retrieved from the /patientappointmentreasons call.
 * @property bool $urgentyn Set this field in order to set the urgent flag in athena (if the practice settings allow for this).
 */
class AppointmentApi extends BaseApiModel
{

    public $appointmenttypeid;
    public $bookingnote;
    public $departmentid;
    public $donotsendconfirmationemail;
    public $ignoreschedulablepermission;
    public $insuranceinfo;
    public $nopatientcase;
    public $patientid;
    public $reasonid;
    public $urgentyn;

    public function rules()
    {
        return [
            [['bookingnote'], 'trim'],
            [['patientid'], 'required'],
            [['bookingnote'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
