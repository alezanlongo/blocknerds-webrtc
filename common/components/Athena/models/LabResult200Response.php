<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $errormessage If the operation failed, this will contain an error message.
 * @property int $labresultid The document ID of the new or modified document.
 * @property string $success Returns true/false if the operation was successful.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class LabResult200Response extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%lab_result200_responses}}';
    }

    public function rules()
    {
        return [
            [['errormessage', 'success'], 'trim'],
            [['errormessage', 'success'], 'string'],
            [['labresultid', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($errormessage = ArrayHelper::getValue($apiObject, 'errormessage')) {
            $this->errormessage = $errormessage;
        }
        if($labresultid = ArrayHelper::getValue($apiObject, 'labresultid')) {
            $this->labresultid = $labresultid;
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
