<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $mac_address Serial number of provided as input parameter.
 * @property string $type Type of the device. Value can be:
 * 
 * 
 * | Value|
 * |---|
 * |Scale|
 * |Babyphone|
 * |Blood Pressure Monitor|
 * |Activity Tracker|
 * |Sleep Monitor|
 * |Smart Connected Thermometer|
 * |Gateway|
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
 * @property string $battery Battery level: high (> 75%), medium (> 30%) or low
 * @property string $deviceid ID of the device. This ID is returned in other services to know which device tracked a data. Then device's model or type can be known using this information.
 * @property string $timezone Timezone of the device.
 * @property int $last_session_date The timestamp of the last server connection of the device
 */
class user_device_mac_objectApi extends BaseApiModel
{

    public $mac_address;
    public $type;
    public $model;
    public $model_id;
    public $battery;
    public $deviceid;
    public $timezone;
    public $last_session_date;

    public function rules()
    {
        return [
            [['mac_address', 'type', 'model', 'battery', 'deviceid', 'timezone'], 'trim'],
            [['mac_address', 'type', 'model', 'battery', 'deviceid', 'timezone'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
