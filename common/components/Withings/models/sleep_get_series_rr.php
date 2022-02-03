<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $timestamp $timestamp represents the epoch value of the respiration rate data, value of this key will be the respiration rate data
 * @property int $value
 * @property integer $sleep_get_series_id
 * @property sleep_get_series $sleep_get_series
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class sleep_get_series_rr extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%wth_sleep_get_series_rrs}}';
    }

    public function rules()
    {
        return [
            [['timestamp', 'value', 'sleep_get_series_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getSleep_get_series()
    {
        return $this->hasOne(sleep_get_series::class, ['id' => 'sleep_get_series_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($timestamp = ArrayHelper::getValue($apiObject, 'timestamp')) {
            $this->timestamp = $timestamp;
        }
        if($value = ArrayHelper::getValue($apiObject, 'value')) {
            $this->value = $value;
        }
        if($sleep_get_series_id = ArrayHelper::getValue($apiObject, 'sleep_get_series_id')) {
            $this->sleep_get_series_id = $sleep_get_series_id;
        }
        if($sleep_get_series = ArrayHelper::getValue($apiObject, 'sleep_get_series')) {
            $this->sleep_get_series = $sleep_get_series;
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
