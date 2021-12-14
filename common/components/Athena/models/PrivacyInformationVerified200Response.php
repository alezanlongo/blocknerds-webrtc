<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $patientid The athena ID of the patient whose privacy information was verified.
 * @property string $success Returns true/false if the operation was successful.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PrivacyInformationVerified200Response extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%privacy_information_verified200_responses}}';
    }

    public function rules()
    {
        return [
            [['success'], 'trim'],
            [['success'], 'string'],
            [['patientid', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($patientid = ArrayHelper::getValue($apiObject, 'patientid')) {
            $this->patientid = $patientid;
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
    /* FIXME link doesn't work
    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);

        return $saved;
    }
    */
}
