<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $errormessage If not successful, will contain error message.
 * @property string $success True if successful.
 * @property string $supportslaterality If true, then laterality may chosen for the diagnosis.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PutDiagnosis200Response extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%put_diagnosis200_responses}}';
    }

    public function rules()
    {
        return [
            [['errormessage', 'success', 'supportslaterality'], 'trim'],
            [['errormessage', 'success', 'supportslaterality'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($errormessage = ArrayHelper::getValue($apiObject, 'errormessage')) {
            $this->errormessage = $errormessage;
        }
        if($success = ArrayHelper::getValue($apiObject, 'success')) {
            $this->success = $success;
        }
        if($supportslaterality = ArrayHelper::getValue($apiObject, 'supportslaterality')) {
            $this->supportslaterality = $supportslaterality;
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
