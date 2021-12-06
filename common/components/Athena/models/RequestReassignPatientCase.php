<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $username AthenNet user to whom the case is being reassigned to.This parameter is case-sensitive.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestReassignPatientCase extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_reassign_patient_cases}}';
    }

    public function rules()
    {
        return [
            [['username'], 'trim'],
            [['username'], 'required'],
            [['username'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($username = ArrayHelper::getValue($apiObject, 'username')) {
            $this->username = $username;
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
