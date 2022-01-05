<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property integer $$timestamp_id $timestamp represents the epoch value of the intraday data
 * @property inline_response_200_13_body_series_timestamp $$timestamp $timestamp represents the epoch value of the intraday data
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_13_body_series extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_13_body_series}}';
    }

    public function rules()
    {
        return [
            [['$timestamp_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function get$timestamp()
    {
        return $this->hasOne(inline_response_200_13_body_series_timestamp::class, ['id' => '$timestamp_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($$timestamp_id = ArrayHelper::getValue($apiObject, '$timestamp_id')) {
            $this->$timestamp_id = $$timestamp_id;
        }
        if($$timestamp = ArrayHelper::getValue($apiObject, '$timestamp')) {
            $this->$timestamp = $$timestamp;
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
