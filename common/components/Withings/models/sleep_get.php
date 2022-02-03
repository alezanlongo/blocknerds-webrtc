<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property int $profile_id
 * @property int $model
 * @property sleep_get_series[] $series
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class sleep_get extends \yii\db\ActiveRecord
{
 
    protected $_seriesAr;

    public static function tableName()
    {
        return '{{%wth_sleep_gets}}';
    }

    public function rules()
    {
        return [
            [['profile_id', 'model', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getSeries()
    {
        return $this->hasMany(sleep_get_series::class, ['sleep_get_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($profile_id = ArrayHelper::getValue($apiObject, 'profile_id')) {
            $this->profile_id = $profile_id;
        }
        if($model = ArrayHelper::getValue($apiObject, 'model')) {
            $this->model = $model;
        }
        if($series = ArrayHelper::getValue($apiObject, 'series')) {
            $this->_seriesAr = $series;
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
        if( !empty($this->_seriesAr) and is_array($this->_seriesAr) ) {
            foreach($this->_seriesAr as $seriesApi) {
                $sleep_get_series = new sleep_get_series();
                $sleep_get_series->loadApiObject($seriesApi);
                $sleep_get_series->link('sleepGet', $this);
                $sleep_get_series->save();
            }
        }

        return $saved;
    }
    */
}
