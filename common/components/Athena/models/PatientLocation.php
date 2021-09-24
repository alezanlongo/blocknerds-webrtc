<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $defaultoncheckin Whether this is the default location once the appointment is checked in and the encounter is created
 * @property string $name Name of this location
 * @property int $patientlocationid Athena patient location ID
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PatientLocation extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%patient_locations}}';
    }

    public function rules()
    {
        return [
            [['defaultoncheckin', 'name'], 'trim'],
            [['defaultoncheckin', 'name'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($defaultoncheckin = ArrayHelper::getValue($apiObject, 'defaultoncheckin')) {
            $this->defaultoncheckin = $defaultoncheckin;
        }
        if($name = ArrayHelper::getValue($apiObject, 'name')) {
            $this->name = $name;
        }
        if($patientlocationid = ArrayHelper::getValue($apiObject, 'patientlocationid')) {
            $this->patientlocationid = $patientlocationid;
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
}
