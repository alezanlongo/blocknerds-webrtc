<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $profile_id
 * @property int $category Category of workout: 
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |1 | Walk|
 * |2 | Run|
 * |3 | Hiking|
 * |4 | Skating|
 * |5 | BMX|
 * |6 | Bicycling|
 * |7 | Swimming|
 * |8 | Surfing|
 * |9 | Kitesurfing|
 * |10 | Windsurfing|
 * |11 | Bodyboard|
 * |12 | Tennis|
 * |13 | Table tennis|
 * |14 | Squash|
 * |15 | Badminton|
 * |16 | Lift weights|
 * |17 | Calisthenics|
 * |18 | Elliptical|
 * |19 | Pilates|
 * |20 | Basket-ball|
 * |21 | Soccer|
 * |22 | Football|
 * |23 | Rugby|
 * |24 | Volley-ball|
 * |25 | Waterpolo|
 * |26 | Horse riding|
 * |27 | Golf|
 * |28 | Yoga|
 * |29 | Dancing|
 * |30 | Boxing|
 * |31 | Fencing|
 * |32 | Wrestling|
 * |33 | Martial arts|
 * |34 | Skiing|
 * |35 | Snowboarding|
 * |36 | Other|
 * |128 | No activity|
 * |187 | Rowing|
 * |188 | Zumba|
 * |191 | Baseball|
 * |192 | Handball|
 * |193 | Hockey|
 * |194 | Ice hockey|
 * |195 | Climbing|
 * |196 | Ice skating|
 * |272 | Multi-sport|
 * |306 | Indoor walk|
 * |307 | Indoor running|
 * |308 | Indoor cycling|
 * @property string $timezone Timezone for the date.
 * @property int $model Source for the workout. Value can be:
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |1 | Withings WBS01, type: 1|
 * |2 | Withings WBS03, type: 1|
 * |3 | Kid Scale, type: 1|
 * |4 | Withings WBS02, type: 1|
 * |5 | Body+, type: 1|
 * |6 | Body Cardio, type: 1|
 * |7 | Body, type: 1|
 * |21 | Smart Baby Monitor, type: 2|
 * |22 | Withings Home, type: 2|
 * |41 | Withings Blood Pressure V1, type: 4|
 * |42 | Withings Blood Pressure V2, type: 4|
 * |43 | Withings Blood Pressure V3, type: 4|
 * |44 | BPM Core, type: 4|
 * |45 | BPM Connect, type: 4|
 * |51 | Pulse, type: 16|
 * |52 | Activite, type: 16|
 * |53 | Activite (Pop, Steel), type: 16|
 * |54 | Withings Go, type: 16|
 * |55 | Activite Steel HR, type: 16|
 * |58 | Pulse HR, type: 16|
 * |59 | Activite Steel HR Sport Edition, type: 16|
 * |60 | Aura dock, type: 32|
 * |61 | Aura sensor, type: 32|
 * |62 | Aura dock, type: 32|
 * |63 | Sleep sensor, type: 32|
 * |70 | Thermo, type: 64|
 * |91 | Move ECG|
 * |92 | Move ECG|
 * |1051 | iOS step tracker, type 16|
 * |1052 | iOS step tracker, type 16|
 * |1053 | Android step tracker, type 16|
 * |1054 | Android step tracker, type 16|
 * |1055 | GoogleFit tracker, type 16|
 * |1056 | Samsung Health tracker, type 16|
 * |1057 | HealthKit step iPhone tracker, type 16|
 * |1058 | HealthKit step Apple Watch tracker, type 16|
 * |1059 | HealthKit other step tracker, type 16|
 * @property int $attrib The way the measure was attributed to the user:
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |0 | The measuregroup has been captured by a device and is known to belong to this user (and is not ambiguous)|
 * |1 | The measuregroup has been captured by a device but may belong to other users as well as this one (it is ambiguous)|
 * |2 | The measuregroup has been entered manually for this particular user|
 * |4 | The measuregroup has been entered manually during user creation (and may not be accurate)|
 * |5 | Measure auto, it's only for the Blood Pressure Monitor. This device can make many measures and computed the best value|
 * |7 | Measure confirmed. You can get this value if the user confirmed a detected activity|
 * |8 | Same as attrib 0|
 * @property int $startdate The starting datetime for workouts data.
 * @property int $enddate The ending datetime for workouts data.
 * @property string $date Date at which the measure was taken or entered.
 * @property int $modified The timestamp of the last modification.
 * @property string $deviceid ID of device that tracked the data. To retrieve information about this device, refer to : <a href='/api-reference/#operation/userv2-getdevice'>User v2 - Getdevice</a>.
 * @property int $workout_object_data__algo_pause_duration *Available for all categories except Multi-sport*<br><br>Total pause time in seconds detected by Withings device (swim only)
 * @property int $workout_object_data__calories *Available for all categories except Multi-sport*<br><br>Active calories burned (in Kcal). *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__distance *Available for all categories except Swimming, Multi-sport*<br><br>Distance travelled (in meters). *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__elevation *Available for all categories except Swimming, Multi-sport*<br><br>Number of floors climbed. *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__hr_average *Available for all categories except Multi-sport*<br><br>Average heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__hr_max *Available for all categories except Multi-sport*<br><br>Maximal heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__hr_min *Available for all categories except Multi-sport*<br><br>Minimal heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__hr_zone_0 *Available for all categories except Multi-sport*<br><br>Duration in seconds when heart rate was in a light zone (cf. <a href='/api-reference/#section/Glossary'>Glossary</a>). *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__hr_zone_1 *Available for all categories except Multi-sport*<br><br>Duration in seconds when heart rate was in a moderate zone (cf. <a href='/api-reference/#section/Glossary'>Glossary</a>). *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__hr_zone_2 *Available for all categories except Multi-sport*<br><br>Duration in seconds when heart rate was in an intense zone (cf. <a href='/api-reference/#section/Glossary'>Glossary</a>). *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__hr_zone_3 *Available for all categories except Multi-sport*<br><br>Duration in seconds when heart rate was in maximal zone (cf. <a href='/api-reference/#section/Glossary'>Glossary</a>). *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__intensity *Available for all categories except Multi-sport*<br><br>Intensity.
 * @property int $workout_object_data__manual_calories *Available for all categories except Multi-sport*<br><br>Active calories burned manually entered by user (in Kcal). *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__manual_distance *Available for all categories except Multi-sport*<br><br>Distance travelled manually entered by user (in meters). *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__pause_duration *Available for all categories except Multi-sport*<br><br>Total pause time in second filled by user
 * @property int $workout_object_data__pool_laps *Available only for Swimming*<br><br>Number of pool laps. *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__pool_length *Available only for Swimming*<br><br>Length of the pool. *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__spo2_average *Available for all categories except Multi-sport*<br><br>Average percent of SpO2 percent value during a workout
 * @property int $workout_object_data__steps *Available for all categories except Swimming, Multi-sport*<br><br>Number of steps. *(Use 'data_fields' to request this data.)*
 * @property int $workout_object_data__strokes *Available only for Swimming*<br><br>Number of strokes. *(Use 'data_fields' to request this data.)*
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class workout_object extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%wth_workout_objects}}';
    }

    public function rules()
    {
        return [
            [['timezone', 'date', 'deviceid'], 'trim'],
            [['timezone', 'date', 'deviceid'], 'string'],
            [['profile_id', 'category', 'model', 'attrib', 'startdate', 'enddate', 'modified', 'workout_object_data__algo_pause_duration', 'workout_object_data__calories', 'workout_object_data__distance', 'workout_object_data__elevation', 'workout_object_data__hr_average', 'workout_object_data__hr_max', 'workout_object_data__hr_min', 'workout_object_data__hr_zone_0', 'workout_object_data__hr_zone_1', 'workout_object_data__hr_zone_2', 'workout_object_data__hr_zone_3', 'workout_object_data__intensity', 'workout_object_data__manual_calories', 'workout_object_data__manual_distance', 'workout_object_data__pause_duration', 'workout_object_data__pool_laps', 'workout_object_data__pool_length', 'workout_object_data__spo2_average', 'workout_object_data__steps', 'workout_object_data__strokes', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($profile_id = ArrayHelper::getValue($apiObject, 'profile_id')) {
            $this->profile_id = $profile_id;
        }
        if($category = ArrayHelper::getValue($apiObject, 'category')) {
            $this->category = $category;
        }
        if($timezone = ArrayHelper::getValue($apiObject, 'timezone')) {
            $this->timezone = $timezone;
        }
        if($model = ArrayHelper::getValue($apiObject, 'model')) {
            $this->model = $model;
        }
        if($attrib = ArrayHelper::getValue($apiObject, 'attrib')) {
            $this->attrib = $attrib;
        }
        if($startdate = ArrayHelper::getValue($apiObject, 'startdate')) {
            $this->startdate = $startdate;
        }
        if($enddate = ArrayHelper::getValue($apiObject, 'enddate')) {
            $this->enddate = $enddate;
        }
        if($date = ArrayHelper::getValue($apiObject, 'date')) {
            $this->date = $date;
        }
        if($modified = ArrayHelper::getValue($apiObject, 'modified')) {
            $this->modified = $modified;
        }
        if($deviceid = ArrayHelper::getValue($apiObject, 'deviceid')) {
            $this->deviceid = $deviceid;
        }
        if($workout_object_data__algo_pause_duration = ArrayHelper::getValue($apiObject, 'data.algo_pause_duration')) {
            $this->workout_object_data__algo_pause_duration = $workout_object_data__algo_pause_duration;
        }
        if($workout_object_data__calories = ArrayHelper::getValue($apiObject, 'data.calories')) {
            $this->workout_object_data__calories = $workout_object_data__calories;
        }
        if($workout_object_data__distance = ArrayHelper::getValue($apiObject, 'data.distance')) {
            $this->workout_object_data__distance = $workout_object_data__distance;
        }
        if($workout_object_data__elevation = ArrayHelper::getValue($apiObject, 'data.elevation')) {
            $this->workout_object_data__elevation = $workout_object_data__elevation;
        }
        if($workout_object_data__hr_average = ArrayHelper::getValue($apiObject, 'data.hr_average')) {
            $this->workout_object_data__hr_average = $workout_object_data__hr_average;
        }
        if($workout_object_data__hr_max = ArrayHelper::getValue($apiObject, 'data.hr_max')) {
            $this->workout_object_data__hr_max = $workout_object_data__hr_max;
        }
        if($workout_object_data__hr_min = ArrayHelper::getValue($apiObject, 'data.hr_min')) {
            $this->workout_object_data__hr_min = $workout_object_data__hr_min;
        }
        if($workout_object_data__hr_zone_0 = ArrayHelper::getValue($apiObject, 'data.hr_zone_0')) {
            $this->workout_object_data__hr_zone_0 = $workout_object_data__hr_zone_0;
        }
        if($workout_object_data__hr_zone_1 = ArrayHelper::getValue($apiObject, 'data.hr_zone_1')) {
            $this->workout_object_data__hr_zone_1 = $workout_object_data__hr_zone_1;
        }
        if($workout_object_data__hr_zone_2 = ArrayHelper::getValue($apiObject, 'data.hr_zone_2')) {
            $this->workout_object_data__hr_zone_2 = $workout_object_data__hr_zone_2;
        }
        if($workout_object_data__hr_zone_3 = ArrayHelper::getValue($apiObject, 'data.hr_zone_3')) {
            $this->workout_object_data__hr_zone_3 = $workout_object_data__hr_zone_3;
        }
        if($workout_object_data__intensity = ArrayHelper::getValue($apiObject, 'data.intensity')) {
            $this->workout_object_data__intensity = $workout_object_data__intensity;
        }
        if($workout_object_data__manual_calories = ArrayHelper::getValue($apiObject, 'data.manual_calories')) {
            $this->workout_object_data__manual_calories = $workout_object_data__manual_calories;
        }
        if($workout_object_data__manual_distance = ArrayHelper::getValue($apiObject, 'data.manual_distance')) {
            $this->workout_object_data__manual_distance = $workout_object_data__manual_distance;
        }
        if($workout_object_data__pause_duration = ArrayHelper::getValue($apiObject, 'data.pause_duration')) {
            $this->workout_object_data__pause_duration = $workout_object_data__pause_duration;
        }
        if($workout_object_data__pool_laps = ArrayHelper::getValue($apiObject, 'data.pool_laps')) {
            $this->workout_object_data__pool_laps = $workout_object_data__pool_laps;
        }
        if($workout_object_data__pool_length = ArrayHelper::getValue($apiObject, 'data.pool_length')) {
            $this->workout_object_data__pool_length = $workout_object_data__pool_length;
        }
        if($workout_object_data__spo2_average = ArrayHelper::getValue($apiObject, 'data.spo2_average')) {
            $this->workout_object_data__spo2_average = $workout_object_data__spo2_average;
        }
        if($workout_object_data__steps = ArrayHelper::getValue($apiObject, 'data.steps')) {
            $this->workout_object_data__steps = $workout_object_data__steps;
        }
        if($workout_object_data__strokes = ArrayHelper::getValue($apiObject, 'data.strokes')) {
            $this->workout_object_data__strokes = $workout_object_data__strokes;
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
