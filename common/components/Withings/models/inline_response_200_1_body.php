<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property integer $user_id
 * @property inline_response_200_1_body_user $user
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_1_body extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_1_bodies}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getUser()
    {
        return $this->hasOne(inline_response_200_1_body_user::class, ['id' => 'user_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($user_id = ArrayHelper::getValue($apiObject, 'user_id')) {
            $this->user_id = $user_id;
        }
        if($user = ArrayHelper::getValue($apiObject, 'user')) {
            $this->user = $user;
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
