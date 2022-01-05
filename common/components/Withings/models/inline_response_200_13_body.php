<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property integer $series_id
 * @property inline_response_200_13_body_series $series
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_13_body extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_13_bodies}}';
    }

    public function rules()
    {
        return [
            [['series_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getSeries()
    {
        return $this->hasOne(inline_response_200_13_body_series::class, ['id' => 'series_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($series_id = ArrayHelper::getValue($apiObject, 'series_id')) {
            $this->series_id = $series_id;
        }
        if($series = ArrayHelper::getValue($apiObject, 'series')) {
            $this->series = $series;
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
