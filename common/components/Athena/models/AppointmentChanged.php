<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property PutAppointment200Response[] $appointments
 * @property int $totalcount
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class AppointmentChanged extends \yii\db\ActiveRecord
{
 
    protected $_appointmentsAr;

    public static function tableName()
    {
        return '{{%appointment_changeds}}';
    }

    public function rules()
    {
        return [
            [['totalcount', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getAppointments()
    {
        return $this->hasMany(PutAppointment200Response::class, ['appointment_changed_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($appointments = ArrayHelper::getValue($apiObject, 'appointments')) {
            $this->_appointmentsAr = $appointments;
        }
        if($totalcount = ArrayHelper::getValue($apiObject, 'totalcount')) {
            $this->totalcount = $totalcount;
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
        if( !empty($this->_appointmentsAr) and is_array($this->_appointmentsAr) ) {
            foreach($this->_appointmentsAr as $appointmentsApi) {
                $putappointment200response = new PutAppointment200Response();
                $putappointment200response->loadApiObject($appointmentsApi);
                $putappointment200response->link('appointmentChanged', $this);
                $putappointment200response->save();
            }
        }

        return $saved;
    }
    */
}
