<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property bool $displayonschedule Add appointment note to homepage display (defaults to false)
 * @property string $notetext The note text.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestAppointmentNote extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_appointment_notes}}';
    }

    public function rules()
    {
        return [
            [['notetext'], 'trim'],
            [['notetext'], 'required'],
            [['notetext'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($displayonschedule = ArrayHelper::getValue($apiObject, 'displayonschedule')) {
            $this->displayonschedule = $displayonschedule;
        }
        if($notetext = ArrayHelper::getValue($apiObject, 'notetext')) {
            $this->notetext = $notetext;
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
