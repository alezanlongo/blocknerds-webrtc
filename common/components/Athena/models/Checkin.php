<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $message Debugging text in case of failure.
 * @property string $success Indicates that this call was successful.  Processing should still continue even if there was an error with this call.  Generally, this will only be false if the appointment is in a good state to start the process, but the startcheckin call was already used.  Other errors may occur, similar to potential errors with /appointments/{appointmentid}/checkin.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Checkin extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%checkins}}';
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

    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);

        return $saved;
    }
}
