<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property string $nonce A random timestamp based token to be used once in requiring signature API services to avoid replay attack
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_15_body extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_15_bodies}}';
    }

    public function rules()
    {
        return [
            [['nonce'], 'trim'],
            [['nonce'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($nonce = ArrayHelper::getValue($apiObject, 'nonce')) {
            $this->nonce = $nonce;
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
