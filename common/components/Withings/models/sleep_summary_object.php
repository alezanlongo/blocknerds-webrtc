<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $profile_id
 * @property string $timezone Timezone for the date.
 * @property int $model The source for sleep data. Value can be 16 for a tracker or 32 for a Sleep Monitor.
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
 * @property int $startdate The starting datetime for the sleep state data.
 * @property int $enddate The end datetime for the sleep data. A single call can span up to 7 days maximum. To cover a wider time range, you will need to perform multiple calls.
 * @property string $date Date at which the measure was taken or entered.
 * @property int $created
 * @property int $modified The timestamp of the last modification.
 * @property int $sleep_summary_object_data__apnea_hypopnea_index Medical grade AHI. Only available for devices purchased in Europe and Australia, with the sleep apnea detection feature activated. Average number of hypopnea and apnea episodes per hour, that occured during sleep time.
 * @property int $sleep_summary_object_data__asleepduration Duration of sleep when night comes from external source (light, deep and rem sleep durations are null in this case). *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__breathing_disturbances_intensity Wellness metric, available for all Sleep and Sleep Analyzer devices. Intensity of <a href='/api-reference/#section/Glossary'>breathing disturbances</a>
 * @property int $sleep_summary_object_data__deepsleepduration Duration in state deep sleep (in seconds). *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__durationtosleep Time to sleep (in seconds). (deprecated) *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__durationtowakeup Time to wake up (in seconds). (deprecated) *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__hr_average Average heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__hr_max Maximal heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__hr_min Minimal heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__lightsleepduration Duration in state light sleep (in seconds). *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__nb_rem_episodes Count of the REM sleep phases. *(Use 'data_fields' to request this data.)*
 * @property string $sleep_summary_object_data__night_events Events list happened during the night
 * @property int $sleep_summary_object_data__out_of_bed_count Number of times the user got out of bed during the night. *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__remsleepduration Duration in state REM sleep (in seconds). *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__rr_average Average respiration rate. *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__rr_max Maximal respiration rate. *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__rr_min Minimal respiration rate. *(Use 'data_fields' to request this data.)*
 * @property float $sleep_summary_object_data__sleep_efficiency Ratio of the total sleep time over the time spent in bed. *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__sleep_latency Time spent in bed before falling asleep. *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__sleep_score Sleep score
 * @property int $sleep_summary_object_data__snoring Total snoring time
 * @property int $sleep_summary_object_data__snoringepisodecount Numbers of snoring episodes of at least one minute
 * @property int $sleep_summary_object_data__total_sleep_time Total time spent asleep. Sum of light, deep and rem durations. *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__total_timeinbed Total time spent in bed. *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__wakeup_latency Time spent in bed after waking up. *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__wakeupcount Number of times the user woke up while in bed. Does not include the number of times the user got out of bed. *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__wakeupduration Time spent awake (in seconds). *(Use 'data_fields' to request this data.)*
 * @property int $sleep_summary_object_data__waso Time spent awake in bed after falling asleep for the 1st time during the night. *(Use 'data_fields' to request this data.)*
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class sleep_summary_object extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%wth_sleep_summary_objects}}';
    }

    public function rules()
    {
        return [
            [['timezone', 'date', 'sleep_summary_object_data__night_events'], 'trim'],
            [['timezone', 'date', 'sleep_summary_object_data__night_events'], 'string'],
            [['profile_id', 'model', 'model_id', 'startdate', 'enddate', 'created', 'modified', 'sleep_summary_object_data__apnea_hypopnea_index', 'sleep_summary_object_data__asleepduration', 'sleep_summary_object_data__breathing_disturbances_intensity', 'sleep_summary_object_data__deepsleepduration', 'sleep_summary_object_data__durationtosleep', 'sleep_summary_object_data__durationtowakeup', 'sleep_summary_object_data__hr_average', 'sleep_summary_object_data__hr_max', 'sleep_summary_object_data__hr_min', 'sleep_summary_object_data__lightsleepduration', 'sleep_summary_object_data__nb_rem_episodes', 'sleep_summary_object_data__out_of_bed_count', 'sleep_summary_object_data__remsleepduration', 'sleep_summary_object_data__rr_average', 'sleep_summary_object_data__rr_max', 'sleep_summary_object_data__rr_min', 'sleep_summary_object_data__sleep_latency', 'sleep_summary_object_data__sleep_score', 'sleep_summary_object_data__snoring', 'sleep_summary_object_data__snoringepisodecount', 'sleep_summary_object_data__total_sleep_time', 'sleep_summary_object_data__total_timeinbed', 'sleep_summary_object_data__wakeup_latency', 'sleep_summary_object_data__wakeupcount', 'sleep_summary_object_data__wakeupduration', 'sleep_summary_object_data__waso', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($profile_id = ArrayHelper::getValue($apiObject, 'profile_id')) {
            $this->profile_id = $profile_id;
        }
        if($timezone = ArrayHelper::getValue($apiObject, 'timezone')) {
            $this->timezone = $timezone;
        }
        if($model = ArrayHelper::getValue($apiObject, 'model')) {
            $this->model = $model;
        }
        if($model_id = ArrayHelper::getValue($apiObject, 'model_id')) {
            $this->model_id = $model_id;
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
        if($created = ArrayHelper::getValue($apiObject, 'created')) {
            $this->created = $created;
        }
        if($modified = ArrayHelper::getValue($apiObject, 'modified')) {
            $this->modified = $modified;
        }
        if($sleep_summary_object_data__apnea_hypopnea_index = ArrayHelper::getValue($apiObject, 'data.apnea_hypopnea_index')) {
            $this->sleep_summary_object_data__apnea_hypopnea_index = $sleep_summary_object_data__apnea_hypopnea_index;
        }
        if($sleep_summary_object_data__asleepduration = ArrayHelper::getValue($apiObject, 'data.asleepduration')) {
            $this->sleep_summary_object_data__asleepduration = $sleep_summary_object_data__asleepduration;
        }
        if($sleep_summary_object_data__breathing_disturbances_intensity = ArrayHelper::getValue($apiObject, 'data.breathing_disturbances_intensity')) {
            $this->sleep_summary_object_data__breathing_disturbances_intensity = $sleep_summary_object_data__breathing_disturbances_intensity;
        }
        if($sleep_summary_object_data__deepsleepduration = ArrayHelper::getValue($apiObject, 'data.deepsleepduration')) {
            $this->sleep_summary_object_data__deepsleepduration = $sleep_summary_object_data__deepsleepduration;
        }
        if($sleep_summary_object_data__durationtosleep = ArrayHelper::getValue($apiObject, 'data.durationtosleep')) {
            $this->sleep_summary_object_data__durationtosleep = $sleep_summary_object_data__durationtosleep;
        }
        if($sleep_summary_object_data__durationtowakeup = ArrayHelper::getValue($apiObject, 'data.durationtowakeup')) {
            $this->sleep_summary_object_data__durationtowakeup = $sleep_summary_object_data__durationtowakeup;
        }
        if($sleep_summary_object_data__hr_average = ArrayHelper::getValue($apiObject, 'data.hr_average')) {
            $this->sleep_summary_object_data__hr_average = $sleep_summary_object_data__hr_average;
        }
        if($sleep_summary_object_data__hr_max = ArrayHelper::getValue($apiObject, 'data.hr_max')) {
            $this->sleep_summary_object_data__hr_max = $sleep_summary_object_data__hr_max;
        }
        if($sleep_summary_object_data__hr_min = ArrayHelper::getValue($apiObject, 'data.hr_min')) {
            $this->sleep_summary_object_data__hr_min = $sleep_summary_object_data__hr_min;
        }
        if($sleep_summary_object_data__lightsleepduration = ArrayHelper::getValue($apiObject, 'data.lightsleepduration')) {
            $this->sleep_summary_object_data__lightsleepduration = $sleep_summary_object_data__lightsleepduration;
        }
        if($sleep_summary_object_data__nb_rem_episodes = ArrayHelper::getValue($apiObject, 'data.nb_rem_episodes')) {
            $this->sleep_summary_object_data__nb_rem_episodes = $sleep_summary_object_data__nb_rem_episodes;
        }
        if($sleep_summary_object_data__night_events = ArrayHelper::getValue($apiObject, 'data.night_events')) {
            $this->sleep_summary_object_data__night_events = $sleep_summary_object_data__night_events;
        }
        if($sleep_summary_object_data__out_of_bed_count = ArrayHelper::getValue($apiObject, 'data.out_of_bed_count')) {
            $this->sleep_summary_object_data__out_of_bed_count = $sleep_summary_object_data__out_of_bed_count;
        }
        if($sleep_summary_object_data__remsleepduration = ArrayHelper::getValue($apiObject, 'data.remsleepduration')) {
            $this->sleep_summary_object_data__remsleepduration = $sleep_summary_object_data__remsleepduration;
        }
        if($sleep_summary_object_data__rr_average = ArrayHelper::getValue($apiObject, 'data.rr_average')) {
            $this->sleep_summary_object_data__rr_average = $sleep_summary_object_data__rr_average;
        }
        if($sleep_summary_object_data__rr_max = ArrayHelper::getValue($apiObject, 'data.rr_max')) {
            $this->sleep_summary_object_data__rr_max = $sleep_summary_object_data__rr_max;
        }
        if($sleep_summary_object_data__rr_min = ArrayHelper::getValue($apiObject, 'data.rr_min')) {
            $this->sleep_summary_object_data__rr_min = $sleep_summary_object_data__rr_min;
        }
        if($sleep_summary_object_data__sleep_efficiency = ArrayHelper::getValue($apiObject, 'data.sleep_efficiency')) {
            $this->sleep_summary_object_data__sleep_efficiency = $sleep_summary_object_data__sleep_efficiency;
        }
        if($sleep_summary_object_data__sleep_latency = ArrayHelper::getValue($apiObject, 'data.sleep_latency')) {
            $this->sleep_summary_object_data__sleep_latency = $sleep_summary_object_data__sleep_latency;
        }
        if($sleep_summary_object_data__sleep_score = ArrayHelper::getValue($apiObject, 'data.sleep_score')) {
            $this->sleep_summary_object_data__sleep_score = $sleep_summary_object_data__sleep_score;
        }
        if($sleep_summary_object_data__snoring = ArrayHelper::getValue($apiObject, 'data.snoring')) {
            $this->sleep_summary_object_data__snoring = $sleep_summary_object_data__snoring;
        }
        if($sleep_summary_object_data__snoringepisodecount = ArrayHelper::getValue($apiObject, 'data.snoringepisodecount')) {
            $this->sleep_summary_object_data__snoringepisodecount = $sleep_summary_object_data__snoringepisodecount;
        }
        if($sleep_summary_object_data__total_sleep_time = ArrayHelper::getValue($apiObject, 'data.total_sleep_time')) {
            $this->sleep_summary_object_data__total_sleep_time = $sleep_summary_object_data__total_sleep_time;
        }
        if($sleep_summary_object_data__total_timeinbed = ArrayHelper::getValue($apiObject, 'data.total_timeinbed')) {
            $this->sleep_summary_object_data__total_timeinbed = $sleep_summary_object_data__total_timeinbed;
        }
        if($sleep_summary_object_data__wakeup_latency = ArrayHelper::getValue($apiObject, 'data.wakeup_latency')) {
            $this->sleep_summary_object_data__wakeup_latency = $sleep_summary_object_data__wakeup_latency;
        }
        if($sleep_summary_object_data__wakeupcount = ArrayHelper::getValue($apiObject, 'data.wakeupcount')) {
            $this->sleep_summary_object_data__wakeupcount = $sleep_summary_object_data__wakeupcount;
        }
        if($sleep_summary_object_data__wakeupduration = ArrayHelper::getValue($apiObject, 'data.wakeupduration')) {
            $this->sleep_summary_object_data__wakeupduration = $sleep_summary_object_data__wakeupduration;
        }
        if($sleep_summary_object_data__waso = ArrayHelper::getValue($apiObject, 'data.waso')) {
            $this->sleep_summary_object_data__waso = $sleep_summary_object_data__waso;
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
