<?php

namespace common\components\Athena\models;

/**
 * 
 *
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

        $this->errormessage = ArrayHelper::getValue($obj, 'errormessage');
        $this->patientid = ArrayHelper::getValue($obj, 'patientid');
        $this->id = ArrayHelper::getValue($obj, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
