<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
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
 */
class activity_objectApi extends BaseApiModel
{

    public $date;
    public $timezone;
    public $deviceid;
    public $hash_deviceid;
    public $brand;
    public $is_tracker;
    public $steps;
    public $distance;
    public $elevation;
    public $soft;
    public $moderate;
    public $intense;
    public $active;
    public $calories;
    public $totalcalories;
    public $hr_average;
    public $hr_min;
    public $hr_max;
    public $hr_zone_0;
    public $hr_zone_1;
    public $hr_zone_2;
    public $hr_zone_3;

    public function rules()
    {
        return [
            [['date', 'timezone', 'deviceid', 'hash_deviceid'], 'trim'],
            [['date', 'timezone', 'deviceid', 'hash_deviceid'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
