<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $errormessage If the operation failed, this will contain any error messages.
 * @property string $success Whether the operation was successful.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PutEncounter200Response extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%put_encounter200_responses}}';
    }

    public function rules()
    {
        return [
            [['errormessage', 'success'], 'trim'],
            [['errormessage', 'success'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        $this->errormessage = ArrayHelper::getValue($apiObject, 'errormessage');
        $this->success = ArrayHelper::getValue($apiObject, 'success');
        $this->id = ArrayHelper::getValue($apiObject, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
