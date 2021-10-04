<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $errormessage If the operation failed, this will contain an error message.
 * @property int $patientcaseid The document ID of the new or modified document.
 * @property string $success Returns true/false if the operation was successful.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PostPatientCase200Response extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%post_patient_case200_responses}}';
    }

    public function rules()
    {
        return [
            [['errormessage', 'success'], 'trim'],
            [['errormessage', 'success'], 'string'],
            [['patientcaseid', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($errormessage = ArrayHelper::getValue($apiObject, 'errormessage')) {
            $this->errormessage = $errormessage;
        }
        if($patientcaseid = ArrayHelper::getValue($apiObject, 'patientcaseid')) {
            $this->patientcaseid = $patientcaseid;
        }
        if($patientcaseid = ArrayHelper::getValue($apiObject, 'patientcaseid')) {
            $this->externalId = $patientcaseid;
        }
        if($success = ArrayHelper::getValue($apiObject, 'success')) {
            $this->success = $success;
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

    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);

        return $saved;
    }
}
