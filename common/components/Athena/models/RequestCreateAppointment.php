<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $appointmentdate The appointment date for the new open appointment slot (mm/dd/yyyy).
 * @property array $appointmenttime The time (hh24:mi) for the new appointment slot.  Multiple times (either as a comma delimited list or multiple POSTed values) are allowed.  24 hour time.
 * @property int $appointmenttypeid The appointment type ID to be created.  Either this or a reason must be provided.
 * @property int $departmentid The athenaNet department ID.
 * @property int $providerid The athenaNet provider ID.
 * @property int $reasonid The appointment reason (/patientappointmentreasons) to be created. Either this or a raw appointment type ID must be provided.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestCreateAppointment extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_create_appointments}}';
    }

    public function rules()
    {
        return [
            [['appointmentdate'], 'trim'],
            [['appointmentdate', 'appointmenttime', 'departmentid', 'providerid'], 'required'],
            [['appointmentdate'], 'string'],
            [['appointmenttypeid', 'departmentid', 'providerid', 'reasonid', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($appointmentdate = ArrayHelper::getValue($apiObject, 'appointmentdate')) {
            $this->appointmentdate = $appointmentdate;
        }
        if($appointmenttime = ArrayHelper::getValue($apiObject, 'appointmenttime')) {
            $this->appointmenttime = $appointmenttime;
        }
        if($appointmenttypeid = ArrayHelper::getValue($apiObject, 'appointmenttypeid')) {
            $this->appointmenttypeid = $appointmenttypeid;
        }
        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($providerid = ArrayHelper::getValue($apiObject, 'providerid')) {
            $this->providerid = $providerid;
        }
        if($reasonid = ArrayHelper::getValue($apiObject, 'reasonid')) {
            $this->reasonid = $reasonid;
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
