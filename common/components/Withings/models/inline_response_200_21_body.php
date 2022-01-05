<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property integer $goals_id
 * @property inline_response_200_21_body_goals $goals
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_21_body extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_21_bodies}}';
    }

    public function rules()
    {
        return [
            [['goals_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getGoals()
    {
        return $this->hasOne(inline_response_200_21_body_goals::class, ['id' => 'goals_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($goals_id = ArrayHelper::getValue($apiObject, 'goals_id')) {
            $this->goals_id = $goals_id;
        }
        if($goals = ArrayHelper::getValue($apiObject, 'goals')) {
            $this->goals = $goals;
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
