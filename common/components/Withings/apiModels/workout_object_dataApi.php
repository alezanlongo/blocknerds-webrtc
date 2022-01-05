<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Details of workout.
 *
 * @property int $algo_pause_duration *Available for all categories except Multi-sport*<br><br>Total pause time in seconds detected by Withings device (swim only)
 * @property int $calories *Available for all categories except Multi-sport*<br><br>Active calories burned (in Kcal). *(Use 'data_fields' to request this data.)*
 * @property int $distance *Available for all categories except Swimming, Multi-sport*<br><br>Distance travelled (in meters). *(Use 'data_fields' to request this data.)*
 * @property int $elevation *Available for all categories except Swimming, Multi-sport*<br><br>Number of floors climbed. *(Use 'data_fields' to request this data.)*
 * @property int $hr_average *Available for all categories except Multi-sport*<br><br>Average heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $hr_max *Available for all categories except Multi-sport*<br><br>Maximal heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $hr_min *Available for all categories except Multi-sport*<br><br>Minimal heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $hr_zone_0 *Available for all categories except Multi-sport*<br><br>Duration in seconds when heart rate was in a light zone (cf. <a href='/api-reference/#section/Glossary'>Glossary</a>). *(Use 'data_fields' to request this data.)*
 * @property int $hr_zone_1 *Available for all categories except Multi-sport*<br><br>Duration in seconds when heart rate was in a moderate zone (cf. <a href='/api-reference/#section/Glossary'>Glossary</a>). *(Use 'data_fields' to request this data.)*
 * @property int $hr_zone_2 *Available for all categories except Multi-sport*<br><br>Duration in seconds when heart rate was in an intense zone (cf. <a href='/api-reference/#section/Glossary'>Glossary</a>). *(Use 'data_fields' to request this data.)*
 * @property int $hr_zone_3 *Available for all categories except Multi-sport*<br><br>Duration in seconds when heart rate was in maximal zone (cf. <a href='/api-reference/#section/Glossary'>Glossary</a>). *(Use 'data_fields' to request this data.)*
 * @property int $intensity *Available for all categories except Multi-sport*<br><br>Intensity.
 * @property int $manual_calories *Available for all categories except Multi-sport*<br><br>Active calories burned manually entered by user (in Kcal). *(Use 'data_fields' to request this data.)*
 * @property int $manual_distance *Available for all categories except Multi-sport*<br><br>Distance travelled manually entered by user (in meters). *(Use 'data_fields' to request this data.)*
 * @property int $pause_duration *Available for all categories except Multi-sport*<br><br>Total pause time in second filled by user
 * @property int $pool_laps *Available only for Swimming*<br><br>Number of pool laps. *(Use 'data_fields' to request this data.)*
 * @property int $pool_length *Available only for Swimming*<br><br>Length of the pool. *(Use 'data_fields' to request this data.)*
 * @property int $spo2_average *Available for all categories except Multi-sport*<br><br>Average percent of SpO2 percent value during a workout
 * @property int $steps *Available for all categories except Swimming, Multi-sport*<br><br>Number of steps. *(Use 'data_fields' to request this data.)*
 * @property int $strokes *Available only for Swimming*<br><br>Number of strokes. *(Use 'data_fields' to request this data.)*
 */
class workout_object_dataApi extends BaseApiModel
{

    public $algo_pause_duration;
    public $calories;
    public $distance;
    public $elevation;
    public $hr_average;
    public $hr_max;
    public $hr_min;
    public $hr_zone_0;
    public $hr_zone_1;
    public $hr_zone_2;
    public $hr_zone_3;
    public $intensity;
    public $manual_calories;
    public $manual_distance;
    public $pause_duration;
    public $pool_laps;
    public $pool_length;
    public $spo2_average;
    public $steps;
    public $strokes;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
    }

}
