<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $errormessage Error message will be returned if show error message flag is set to true and patient match found.
 * @property string $patientid Please remember to never disclose this ID to patients since it may result in inadvertant disclosure that a patient exists in a practice already.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PostPatient200Response extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%post_patient200_responses}}';
    }

    public function rules()
    {
        return [
            [['errormessage', 'patientid'], 'trim'],
            [['errormessage', 'patientid'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($errormessage = ArrayHelper::getValue($apiObject, 'errormessage')) {
            $this->errormessage = $errormessage;
        }
        if($patientid = ArrayHelper::getValue($apiObject, 'patientid')) {
            $this->patientid = $patientid;
        }
        if($patientid = ArrayHelper::getValue($apiObject, 'patientid')) {
            $this->externalId = $patientid;
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
