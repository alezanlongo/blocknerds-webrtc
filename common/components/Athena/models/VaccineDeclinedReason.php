<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $active Indicates whether the declined reason is currently active and may be used for creating new orders
 * @property string $declinedreason The reason that the patient declined the vaccine. Required if the declined date is passed in. Defaults to "Patient decision".
 * @property string $declinedreasonid The declined reason ID.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class VaccineDeclinedReason extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%vaccine_declined_reasons}}';
    }

    public function rules()
    {
        return [
            [['active', 'declinedreason', 'declinedreasonid'], 'trim'],
            [['active', 'declinedreason', 'declinedreasonid'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($active = ArrayHelper::getValue($apiObject, 'active')) {
            $this->active = $active;
        }
        if($declinedreason = ArrayHelper::getValue($apiObject, 'declinedreason')) {
            $this->declinedreason = $declinedreason;
        }
        if($declinedreasonid = ArrayHelper::getValue($apiObject, 'declinedreasonid')) {
            $this->declinedreasonid = $declinedreasonid;
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
