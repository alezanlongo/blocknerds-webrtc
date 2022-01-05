<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $date Date of the aggregated data.
 * @property string $timezone Timezone for the date.
 * @property string $deviceid ID of device that tracked the data. To retrieve information about this device, refer to : <a href='/api-reference/#operation/userv2-getdevice'>User v2 - Getdevice</a>.
 * @property string $hash_deviceid ID of device that tracked the data. To retrieve information about this device, refer to : <a href='/api-reference/#operation/userv2-getdevice'>User v2 - Getdevice</a>.
 * @property int $brand Specifies if data comes from Withings (device or mobile application tracker) or an external way (Value is 1 for Withings and 18 for external)
 * @property bool $is_tracker Is true if data was tracked by a Withings tracker (such as Pulse, Go and Watches) otherwise data was tracked by a mobile application or an external way
 * @property int $steps Number of steps. *(Use 'data_fields' to request this data.)*
 * @property float $distance Distance travelled (in meters). *(Use 'data_fields' to request this data.)*
 * @property float $elevation Number of floors climbed. *(Use 'data_fields' to request this data.)*
 * @property int $soft Duration of soft activities (in seconds). *(Use 'data_fields' to request this data.)*
 * @property int $moderate Duration of moderate activities (in seconds). *(Use 'data_fields' to request this data.)*
 * @property int $intense Duration of intense activities (in seconds). *(Use 'data_fields' to request this data.)*
 * @property int $active Sum of intense and moderate activity durations (in seconds). *(Use 'data_fields' to request this data.)*
 * @property float $calories Active calories burned (in Kcal). Calculated by mixing fine granularity calories estimation, workouts estimated calories and calories manually set by the user. *(Use 'data_fields' to request this data.)*
 * @property float $totalcalories Total calories burned (in Kcal). Obtained by adding active calories (see ```calories```) and passive calories.
 * @property int $hr_average Average heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $hr_min Minimal heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $hr_max Maximal heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $hr_zone_0 Duration in seconds when heart rate was in a light zone (cf. <a href='/api-reference/#section/Glossary'>Glossary</a>). *(Use 'data_fields' to request this data.)*
 * @property int $hr_zone_1 Duration in seconds when heart rate was in a moderate zone (cf. <a href='/api-reference/#section/Glossary'>Glossary</a>). *(Use 'data_fields' to request this data.)*
 * @property int $hr_zone_2 Duration in seconds when heart rate was in an intense zone (cf. <a href='/api-reference/#section/Glossary'>Glossary</a>). *(Use 'data_fields' to request this data.)*
 * @property int $hr_zone_3 Duration in seconds when heart rate was in maximal zone (cf. <a href='/api-reference/#section/Glossary'>Glossary</a>). *(Use 'data_fields' to request this data.)*
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class activity_object extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%activity_objects}}';
    }

    public function rules()
    {
        return [
            [['date', 'timezone', 'deviceid', 'hash_deviceid'], 'trim'],
            [['date', 'timezone', 'deviceid', 'hash_deviceid'], 'string'],
            [['brand', 'steps', 'soft', 'moderate', 'intense', 'active', 'hr_average', 'hr_min', 'hr_max', 'hr_zone_0', 'hr_zone_1', 'hr_zone_2', 'hr_zone_3', 'externalId', 'id'], 'integer'],
            [['is_tracker'], 'boolean'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($date = ArrayHelper::getValue($apiObject, 'date')) {
            $this->date = $date;
        }
        if($timezone = ArrayHelper::getValue($apiObject, 'timezone')) {
            $this->timezone = $timezone;
        }
        if($deviceid = ArrayHelper::getValue($apiObject, 'deviceid')) {
            $this->deviceid = $deviceid;
        }
        if($hash_deviceid = ArrayHelper::getValue($apiObject, 'hash_deviceid')) {
            $this->hash_deviceid = $hash_deviceid;
        }
        if($brand = ArrayHelper::getValue($apiObject, 'brand')) {
            $this->brand = $brand;
        }
        if($is_tracker = ArrayHelper::getValue($apiObject, 'is_tracker')) {
            $this->is_tracker = $is_tracker;
        }
        if($steps = ArrayHelper::getValue($apiObject, 'steps')) {
            $this->steps = $steps;
        }
        if($distance = ArrayHelper::getValue($apiObject, 'distance')) {
            $this->distance = $distance;
        }
        if($elevation = ArrayHelper::getValue($apiObject, 'elevation')) {
            $this->elevation = $elevation;
        }
        if($soft = ArrayHelper::getValue($apiObject, 'soft')) {
            $this->soft = $soft;
        }
        if($moderate = ArrayHelper::getValue($apiObject, 'moderate')) {
            $this->moderate = $moderate;
        }
        if($intense = ArrayHelper::getValue($apiObject, 'intense')) {
            $this->intense = $intense;
        }
        if($active = ArrayHelper::getValue($apiObject, 'active')) {
            $this->active = $active;
        }
        if($calories = ArrayHelper::getValue($apiObject, 'calories')) {
            $this->calories = $calories;
        }
        if($totalcalories = ArrayHelper::getValue($apiObject, 'totalcalories')) {
            $this->totalcalories = $totalcalories;
        }
        if($hr_average = ArrayHelper::getValue($apiObject, 'hr_average')) {
            $this->hr_average = $hr_average;
        }
        if($hr_min = ArrayHelper::getValue($apiObject, 'hr_min')) {
            $this->hr_min = $hr_min;
        }
        if($hr_max = ArrayHelper::getValue($apiObject, 'hr_max')) {
            $this->hr_max = $hr_max;
        }
        if($hr_zone_0 = ArrayHelper::getValue($apiObject, 'hr_zone_0')) {
            $this->hr_zone_0 = $hr_zone_0;
        }
        if($hr_zone_1 = ArrayHelper::getValue($apiObject, 'hr_zone_1')) {
            $this->hr_zone_1 = $hr_zone_1;
        }
        if($hr_zone_2 = ArrayHelper::getValue($apiObject, 'hr_zone_2')) {
            $this->hr_zone_2 = $hr_zone_2;
        }
        if($hr_zone_3 = ArrayHelper::getValue($apiObject, 'hr_zone_3')) {
            $this->hr_zone_3 = $hr_zone_3;
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
