<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $actionreasonid Valid Document Action Reason ID for closure of Patient Case.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestClosePatientCase extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_close_patient_cases}}';
    }

    public function rules()
    {
        return [
            [['actionreasonid'], 'required'],
            [['actionreasonid', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($actionreasonid = ArrayHelper::getValue($apiObject, 'actionreasonid')) {
            $this->actionreasonid = $actionreasonid;
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
