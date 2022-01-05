<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Weight. *
 * @property int $value Value for the measure in S.I. units (kilograms, meters etc...). Value should be multiplied by 10 to the power of ```units``` to get the real value.
 * @property int $unit Power of ten to multiply the ```value``` field to get the real value.<br>Formula: ```value * 10^unit = real value```.<br>Eg: ```value = 20 and unit = -1 => real value = 2```.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_21_body_goals_weight extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_21_body_goals_weights}}';
    }

    public function rules()
    {
        return [
            [['value', 'unit', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($value = ArrayHelper::getValue($apiObject, 'value')) {
            $this->value = $value;
        }
        if($unit = ArrayHelper::getValue($apiObject, 'unit')) {
            $this->unit = $unit;
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
