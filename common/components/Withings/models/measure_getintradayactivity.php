<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $profile_id
 * @property int $timestamp $timestamp represents the epoch value of the intraday data
 * @property string $deviceid ID of device that tracked the data. To retrieve information about this device, refer to : <a href='/api-reference/#operation/userv2-getdevice'>User v2 - Getdevice</a>.
 * @property string $model Device model. Value can be:
 * | Value | Description|
 * |---|---|
 * |Withings WBS01 | Scale|
 * |WS30 | Scale|
 * |Kid Scale | Scale|
 * |Smart Body Analyzer | Scale|
 * |Body+ | Scale|
 * |Body Cardio | Scale|
 * |Body | Scale|
 * |WBS08 | Scale|
 * |Body Pro | Scale|
 * |WBS10 | Scale|
 * |WBS11 | Scale|
 * |Smart Baby Monitor | Babyphone|
 * |Withings Home | Babyphone|
 * |Withings Blood Pressure Monitor V1 | Blood Pressure Monitor|
 * |Withings Blood Pressure Monitor V2 | Blood Pressure Monitor|
 * |Withings Blood Pressure Monitor V3 | Blood Pressure Monitor|
 * |BPM Core | Blood Pressure Monitor|
 * |BPM Connect | Blood Pressure Monitor|
 * |BPM Connect Pro | Blood Pressure Monitor|
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
 * |Aura Dock | Sleep Monitor|
 * |Aura Sensor | Sleep Monitor|
 * |Aura Sensor V2 | Sleep Monitor|
 * |Thermo | Smart Connected Thermometer|
 * |WUP01 | Gateway|
 * @property int $model_id | Value | Description|
 * |---|---|
 * |1 | Withings WBS01|
 * |2 | WS30|
 * |3 | Kid Scale|
 * |4 | Smart Body Analyzer|
 * |5 | Body+|
 * |6 | Body Cardio|
 * |7 | Body|
 * |10 | WBS08|
 * |9 | Body Pro|
 * |11 | WBS10|
 * |12 | WBS11|
 * |21 | Smart Baby Monitor|
 * |22 | Withings Home|
 * |41 | Withings Blood Pressure Monitor V1|
 * |42 | Withings Blood Pressure Monitor V2|
 * |43 | Withings Blood Pressure Monitor V3|
 * |44 | BPM Core|
 * |45 | BPM Connect|
 * |46 | BPM Connect Pro|
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
 * |60 | Aura Dock|
 * |61 | Aura Sensor|
 * |63 | Aura Sensor V2|
 * |70 | Thermo|
 * |100 | WUP01|
 * @property int $steps Number of steps. *(Use 'data_fields' to request this data.)*
 * @property float $elevation Number of floors climbed. *(Use 'data_fields' to request this data.)*
 * @property float $calories Estimation of active calories burned (in Kcal). *(Use 'data_fields' to request this data.)*
 * @property float $distance Distance travelled (in meters). *(Use 'data_fields' to request this data.)*
 * @property int $stroke Number of strokes performed. *(Use 'data_fields' to request this data.)*
 * @property int $pool_lap Number of pool_lap performed. *(Use 'data_fields' to request this data.)*
 * @property int $duration Duration of the activity (in seconds). *(Use 'data_fields' to request this data.)*
 * @property int $heart_rate Measured heart rate. *(Use 'data_fields' to request this data.)*
 * @property float $spo2_auto SpO2 measurement automatically tracked by a device tracker
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class measure_getintradayactivity extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%wth_measure_getintradayactivities}}';
    }

    public function rules()
    {
        return [
            [['deviceid', 'model'], 'trim'],
            [['deviceid', 'model'], 'string'],
            [['profile_id', 'timestamp', 'model_id', 'steps', 'stroke', 'pool_lap', 'duration', 'heart_rate', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($profile_id = ArrayHelper::getValue($apiObject, 'profile_id')) {
            $this->profile_id = $profile_id;
        }
        if($timestamp = ArrayHelper::getValue($apiObject, 'timestamp')) {
            $this->timestamp = $timestamp;
        }
        if($deviceid = ArrayHelper::getValue($apiObject, 'deviceid')) {
            $this->deviceid = $deviceid;
        }
        if($model = ArrayHelper::getValue($apiObject, 'model')) {
            $this->model = $model;
        }
        if($model_id = ArrayHelper::getValue($apiObject, 'model_id')) {
            $this->model_id = $model_id;
        }
        if($steps = ArrayHelper::getValue($apiObject, 'steps')) {
            $this->steps = $steps;
        }
        if($elevation = ArrayHelper::getValue($apiObject, 'elevation')) {
            $this->elevation = $elevation;
        }
        if($calories = ArrayHelper::getValue($apiObject, 'calories')) {
            $this->calories = $calories;
        }
        if($distance = ArrayHelper::getValue($apiObject, 'distance')) {
            $this->distance = $distance;
        }
        if($stroke = ArrayHelper::getValue($apiObject, 'stroke')) {
            $this->stroke = $stroke;
        }
        if($pool_lap = ArrayHelper::getValue($apiObject, 'pool_lap')) {
            $this->pool_lap = $pool_lap;
        }
        if($duration = ArrayHelper::getValue($apiObject, 'duration')) {
            $this->duration = $duration;
        }
        if($heart_rate = ArrayHelper::getValue($apiObject, 'heart_rate')) {
            $this->heart_rate = $heart_rate;
        }
        if($spo2_auto = ArrayHelper::getValue($apiObject, 'spo2_auto')) {
            $this->spo2_auto = $spo2_auto;
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
