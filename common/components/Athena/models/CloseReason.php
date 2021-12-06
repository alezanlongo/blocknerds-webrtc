<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $reason Human readable string for the reason.
 * @property int $reasonid ID of the reason.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class CloseReason extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%close_reasons}}';
    }

    public function rules()
    {
        return [
            [['reason'], 'trim'],
            [['reason'], 'string'],
            [['reasonid', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($reason = ArrayHelper::getValue($apiObject, 'reason')) {
            $this->reason = $reason;
        }
        if($reasonid = ArrayHelper::getValue($apiObject, 'reasonid')) {
            $this->reasonid = $reasonid;
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
