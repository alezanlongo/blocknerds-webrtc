<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Details of workout. *
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
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class workout_object_data extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%wth_workout_object_datas}}';
    }

    public function rules()
    {
        return [
            [['algo_pause_duration', 'calories', 'distance', 'elevation', 'hr_average', 'hr_max', 'hr_min', 'hr_zone_0', 'hr_zone_1', 'hr_zone_2', 'hr_zone_3', 'intensity', 'manual_calories', 'manual_distance', 'pause_duration', 'pool_laps', 'pool_length', 'spo2_average', 'steps', 'strokes', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($algo_pause_duration = ArrayHelper::getValue($apiObject, 'algo_pause_duration')) {
            $this->algo_pause_duration = $algo_pause_duration;
        }
        if($calories = ArrayHelper::getValue($apiObject, 'calories')) {
            $this->calories = $calories;
        }
        if($distance = ArrayHelper::getValue($apiObject, 'distance')) {
            $this->distance = $distance;
        }
        if($elevation = ArrayHelper::getValue($apiObject, 'elevation')) {
            $this->elevation = $elevation;
        }
        if($hr_average = ArrayHelper::getValue($apiObject, 'hr_average')) {
            $this->hr_average = $hr_average;
        }
        if($hr_max = ArrayHelper::getValue($apiObject, 'hr_max')) {
            $this->hr_max = $hr_max;
        }
        if($hr_min = ArrayHelper::getValue($apiObject, 'hr_min')) {
            $this->hr_min = $hr_min;
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
        if($intensity = ArrayHelper::getValue($apiObject, 'intensity')) {
            $this->intensity = $intensity;
        }
        if($manual_calories = ArrayHelper::getValue($apiObject, 'manual_calories')) {
            $this->manual_calories = $manual_calories;
        }
        if($manual_distance = ArrayHelper::getValue($apiObject, 'manual_distance')) {
            $this->manual_distance = $manual_distance;
        }
        if($pause_duration = ArrayHelper::getValue($apiObject, 'pause_duration')) {
            $this->pause_duration = $pause_duration;
        }
        if($pool_laps = ArrayHelper::getValue($apiObject, 'pool_laps')) {
            $this->pool_laps = $pool_laps;
        }
        if($pool_length = ArrayHelper::getValue($apiObject, 'pool_length')) {
            $this->pool_length = $pool_length;
        }
        if($spo2_average = ArrayHelper::getValue($apiObject, 'spo2_average')) {
            $this->spo2_average = $spo2_average;
        }
        if($steps = ArrayHelper::getValue($apiObject, 'steps')) {
            $this->steps = $steps;
        }
        if($strokes = ArrayHelper::getValue($apiObject, 'strokes')) {
            $this->strokes = $strokes;
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
