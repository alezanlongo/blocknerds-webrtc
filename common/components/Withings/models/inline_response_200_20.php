<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $status Response status. See <a href='#section/Response-status'>Status</a> section for details.
 * @property integer $body_id Response data.
 * @property inline_response_200_20_body $body Response data.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_20 extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_20s}}';
    }

    public function rules()
    {
        return [
            [['status', 'body_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getBody()
    {
        return $this->hasOne(inline_response_200_20_body::class, ['id' => 'body_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($status = ArrayHelper::getValue($apiObject, 'status')) {
            $this->status = $status;
        }
        if($body_id = ArrayHelper::getValue($apiObject, 'body_id')) {
            $this->body_id = $body_id;
        }
        if($body = ArrayHelper::getValue($apiObject, 'body')) {
            $this->body = $body;
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
