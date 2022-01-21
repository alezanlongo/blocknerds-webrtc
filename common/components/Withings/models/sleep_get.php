<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property object $series
 * @property string $model Device model. Value can be:
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |Aura Dock | Sleep Monitor|
 * |Aura Sensor | Sleep Monitor|
 * |Aura Sensor V2 | Sleep Monitor|
 * |Pulse | Activity Tracker|
 * |Activite | Activity Tracker|
 * |Activite (Pop, Steel) | Activity Tracker|
 * |Withings Go | Activity Tracker|
 * |Activite Steel HR | Activity Tracker|
 * |Activite Steel HR Sport Edition | Activity Tracker|
 * |Pulse HR | Activity Tracker|
 * |Move | Activity Tracker|
 * |Move ECG | Activity Tracker|
 * |ScanWatch | Activity Tracker|
 * @property int $model_id 
 * 
 * | Value | Description|
 * |---|---|
 * |60 | Aura Dock|
 * |61 | Aura Sensor|
 * |63 | Aura Sensor V2|
 * |51 | Pulse|
 * |52 | Activite|
 * |53 | Activite (Pop, Steel)|
 * |54 | Withings Go|
 * |55 | Activite Steel HR|
 * |59 | Activite Steel HR Sport Edition|
 * |58 | Pulse HR|
 * |90 | Move|
 * |91 | Move ECG|
 * |92 | Move ECG|
 * |93 | ScanWatch|
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class sleep_get extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%wth_sleep_gets}}';
    }

    public function rules()
    {
        return [
            [['model'], 'trim'],
            [['model'], 'string'],
            [['model_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($series = ArrayHelper::getValue($apiObject, 'series')) {
            $this->series = $series;
        }
        if($model = ArrayHelper::getValue($apiObject, 'model')) {
            $this->model = $model;
        }
        if($model_id = ArrayHelper::getValue($apiObject, 'model_id')) {
            $this->model_id = $model_id;
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
