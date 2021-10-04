<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property object $appointmentids An hash of appointment IDs to the time requested.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class AppointmentResponse extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%appointment_responses}}';
    }

    public function rules()
    {
        return [
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($appointmentids = ArrayHelper::getValue($apiObject, 'appointmentids')) {
            $this->appointmentids = $appointmentids;
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
