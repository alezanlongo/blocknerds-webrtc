<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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
 * @property string $hash_deviceid ID of the device. This ID is returned in other services to know which device tracked a data. Then device's model or type can be known using this information.
 * @property string $timezone Timezone of the device.
 * @property int $last_session_date The timestamp of the last server connection of the device
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class user_device_object extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%wth_user_device_objects}}';
    }

    public function rules()
    {
        return [
            [['type', 'model', 'battery', 'deviceid', 'hash_deviceid', 'timezone'], 'trim'],
            [['type', 'model', 'battery', 'deviceid', 'hash_deviceid', 'timezone'], 'string'],
            [['model_id', 'last_session_date', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($type = ArrayHelper::getValue($apiObject, 'type')) {
            $this->type = $type;
        }
        if($model = ArrayHelper::getValue($apiObject, 'model')) {
            $this->model = $model;
        }
        if($model_id = ArrayHelper::getValue($apiObject, 'model_id')) {
            $this->model_id = $model_id;
        }
        if($battery = ArrayHelper::getValue($apiObject, 'battery')) {
            $this->battery = $battery;
        }
        if($deviceid = ArrayHelper::getValue($apiObject, 'deviceid')) {
            $this->deviceid = $deviceid;
        }
        if($hash_deviceid = ArrayHelper::getValue($apiObject, 'hash_deviceid')) {
            $this->hash_deviceid = $hash_deviceid;
        }
        if($timezone = ArrayHelper::getValue($apiObject, 'timezone')) {
            $this->timezone = $timezone;
        }
        if($last_session_date = ArrayHelper::getValue($apiObject, 'last_session_date')) {
            $this->last_session_date = $last_session_date;
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
