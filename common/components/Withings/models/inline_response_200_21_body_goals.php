<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $steps Number of steps per day.
 * @property int $sleep Sleep duration (in seconds).
 * @property integer $weight_id Weight.
 * @property inline_response_200_21_body_goals_weight $weight Weight.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_21_body_goals extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_21_body_goals}}';
    }

    public function rules()
    {
        return [
            [['steps', 'sleep', 'weight_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getWeight()
    {
        return $this->hasOne(inline_response_200_21_body_goals_weight::class, ['id' => 'weight_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($steps = ArrayHelper::getValue($apiObject, 'steps')) {
            $this->steps = $steps;
        }
        if($sleep = ArrayHelper::getValue($apiObject, 'sleep')) {
            $this->sleep = $sleep;
        }
        if($weight_id = ArrayHelper::getValue($apiObject, 'weight_id')) {
            $this->weight_id = $weight_id;
        }
        if($weight = ArrayHelper::getValue($apiObject, 'weight')) {
            $this->weight = $weight;
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
