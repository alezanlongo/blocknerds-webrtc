<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $patientstatusname The patient status name
 * @property int $patientstatusid The patient status ID.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PatientStatus extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%patient_statuses}}';
    }

    public function rules()
    {
        return [
            [['patientstatusname'], 'trim'],
            [['patientstatusname'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        $this->patientstatusname = ArrayHelper::getValue($apiObject, 'patientstatusname');
        $this->patientstatusid = ArrayHelper::getValue($apiObject, 'patientstatusid');
        $this->id = ArrayHelper::getValue($apiObject, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
