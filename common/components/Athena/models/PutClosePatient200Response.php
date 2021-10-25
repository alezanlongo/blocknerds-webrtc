<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $error String denoting the failure for cse closure.
 * @property string $success Boolean to denote success or failure.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PutClosePatient200Response extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%put_close_patient200_responses}}';
    }

    public function rules()
    {
        return [
            [['error', 'success'], 'trim'],
            [['error', 'success'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($error = ArrayHelper::getValue($apiObject, 'error')) {
            $this->error = $error;
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
