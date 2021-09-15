<?php

namespace common\components\Athena\models;

/**
 * 
 *
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
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        $this->appointmentdate = ArrayHelper::getValue($obj, 'appointmentdate');
        $this->appointmenttime = ArrayHelper::getValue($obj, 'appointmenttime');
        $this->appointmenttypeid = ArrayHelper::getValue($obj, 'appointmenttypeid');
        $this->departmentid = ArrayHelper::getValue($obj, 'departmentid');
        $this->providerid = ArrayHelper::getValue($obj, 'providerid');
        $this->reasonid = ArrayHelper::getValue($obj, 'reasonid');
        $this->id = ArrayHelper::getValue($obj, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
