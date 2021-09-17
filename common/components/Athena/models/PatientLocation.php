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

        $this->defaultoncheckin = ArrayHelper::getValue($apiObject, 'defaultoncheckin');
        $this->name = ArrayHelper::getValue($apiObject, 'name');
        $this->patientlocationid = ArrayHelper::getValue($apiObject, 'patientlocationid');
        $this->id = ArrayHelper::getValue($apiObject, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
