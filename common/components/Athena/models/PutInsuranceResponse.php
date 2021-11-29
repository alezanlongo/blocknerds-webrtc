<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $message If success is false, this contains an error message with more detail.
 * @property string $success True if operation was sucessful, false otherwise.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PutInsuranceResponse extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%put_insurance_responses}}';
    }

    public function rules()
    {
        return [
            [['message', 'success'], 'trim'],
            [['message', 'success'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($message = ArrayHelper::getValue($apiObject, 'message')) {
            $this->message = $message;
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
