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
            [['patientstatusid', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($patientstatusname = ArrayHelper::getValue($apiObject, 'patientstatusname')) {
            $this->patientstatusname = $patientstatusname;
        }
        if($patientstatusid = ArrayHelper::getValue($apiObject, 'patientstatusid')) {
            $this->patientstatusid = $patientstatusid;
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
