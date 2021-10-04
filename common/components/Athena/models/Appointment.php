<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Appointment extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%appointments}}';
    }

    public function rules()
    {
        return [
            [['bookingnote'], 'trim'],
            [['patientid'], 'required'],
            [['bookingnote'], 'string'],
            [['appointmenttypeid', 'departmentid', 'patientid', 'reasonid', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($appointmenttypeid = ArrayHelper::getValue($apiObject, 'appointmenttypeid')) {
            $this->appointmenttypeid = $appointmenttypeid;
        }
        if($bookingnote = ArrayHelper::getValue($apiObject, 'bookingnote')) {
            $this->bookingnote = $bookingnote;
        }
        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($donotsendconfirmationemail = ArrayHelper::getValue($apiObject, 'donotsendconfirmationemail')) {
            $this->donotsendconfirmationemail = $donotsendconfirmationemail;
        }
        if($ignoreschedulablepermission = ArrayHelper::getValue($apiObject, 'ignoreschedulablepermission')) {
            $this->ignoreschedulablepermission = $ignoreschedulablepermission;
        }
        if($insuranceinfo = ArrayHelper::getValue($apiObject, 'insuranceinfo')) {
            $this->insuranceinfo = $insuranceinfo;
        }
        if($nopatientcase = ArrayHelper::getValue($apiObject, 'nopatientcase')) {
            $this->nopatientcase = $nopatientcase;
        }
        if($patientid = ArrayHelper::getValue($apiObject, 'patientid')) {
            $this->patientid = $patientid;
        }
        if($reasonid = ArrayHelper::getValue($apiObject, 'reasonid')) {
            $this->reasonid = $reasonid;
        }
        if($urgentyn = ArrayHelper::getValue($apiObject, 'urgentyn')) {
            $this->urgentyn = $urgentyn;
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
