<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * $timestamp represents the epoch value of the intraday data
 *
 * @property string $deviceid ID of device that tracked the data. To retrieve information about this device, refer to : <a href='/api-reference/#operation/userv2-getdevice'>User v2 - Getdevice</a>.
 * @property string $model Device model. Value can be:
 * 
 * 
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
 * @property int $model_id 
 * 
 * | Value | Description|
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
 */
class inline_response_200_13_body_series_timestampApi extends BaseApiModel
{

    public $deviceid;
    public $model;
    public $model_id;
    public $steps;
    public $elevation;
    public $calories;
    public $distance;
    public $stroke;
    public $pool_lap;
    public $duration;
    public $heart_rate;
    public $spo2_auto;

    public function rules()
    {
        return [
            [['deviceid', 'model'], 'trim'],
            [['deviceid', 'model'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
