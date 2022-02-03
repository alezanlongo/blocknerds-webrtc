<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Details of sleep. *
 * @property int $apnea_hypopnea_index Medical grade AHI. Only available for devices purchased in Europe and Australia, with the sleep apnea detection feature activated. Average number of hypopnea and apnea episodes per hour, that occured during sleep time.
 * @property int $asleepduration Duration of sleep when night comes from external source (light, deep and rem sleep durations are null in this case). *(Use 'data_fields' to request this data.)*
 * @property int $breathing_disturbances_intensity Wellness metric, available for all Sleep and Sleep Analyzer devices. Intensity of <a href='/api-reference/#section/Glossary'>breathing disturbances</a>
 * @property int $deepsleepduration Duration in state deep sleep (in seconds). *(Use 'data_fields' to request this data.)*
 * @property int $durationtosleep Time to sleep (in seconds). (deprecated) *(Use 'data_fields' to request this data.)*
 * @property int $durationtowakeup Time to wake up (in seconds). (deprecated) *(Use 'data_fields' to request this data.)*
 * @property int $hr_average Average heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $hr_max Maximal heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $hr_min Minimal heart rate. *(Use 'data_fields' to request this data.)*
 * @property int $lightsleepduration Duration in state light sleep (in seconds). *(Use 'data_fields' to request this data.)*
 * @property int $nb_rem_episodes Count of the REM sleep phases. *(Use 'data_fields' to request this data.)*
 * @property string $night_events Events list happened during the night
 * @property int $out_of_bed_count Number of times the user got out of bed during the night. *(Use 'data_fields' to request this data.)*
 * @property int $remsleepduration Duration in state REM sleep (in seconds). *(Use 'data_fields' to request this data.)*
 * @property int $rr_average Average respiration rate. *(Use 'data_fields' to request this data.)*
 * @property int $rr_max Maximal respiration rate. *(Use 'data_fields' to request this data.)*
 * @property int $rr_min Minimal respiration rate. *(Use 'data_fields' to request this data.)*
 * @property float $sleep_efficiency Ratio of the total sleep time over the time spent in bed. *(Use 'data_fields' to request this data.)*
 * @property int $sleep_latency Time spent in bed before falling asleep. *(Use 'data_fields' to request this data.)*
 * @property int $sleep_score Sleep score
 * @property int $snoring Total snoring time
 * @property int $snoringepisodecount Numbers of snoring episodes of at least one minute
 * @property int $total_sleep_time Total time spent asleep. Sum of light, deep and rem durations. *(Use 'data_fields' to request this data.)*
 * @property int $total_timeinbed Total time spent in bed. *(Use 'data_fields' to request this data.)*
 * @property int $wakeup_latency Time spent in bed after waking up. *(Use 'data_fields' to request this data.)*
 * @property int $wakeupcount Number of times the user woke up while in bed. Does not include the number of times the user got out of bed. *(Use 'data_fields' to request this data.)*
 * @property int $wakeupduration Time spent awake (in seconds). *(Use 'data_fields' to request this data.)*
 * @property int $waso Time spent awake in bed after falling asleep for the 1st time during the night. *(Use 'data_fields' to request this data.)*
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class sleep_summary_object_data extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%wth_sleep_summary_object_datas}}';
    }

    public function rules()
    {
        return [
            [['night_events'], 'trim'],
            [['night_events'], 'string'],
            [['apnea_hypopnea_index', 'asleepduration', 'breathing_disturbances_intensity', 'deepsleepduration', 'durationtosleep', 'durationtowakeup', 'hr_average', 'hr_max', 'hr_min', 'lightsleepduration', 'nb_rem_episodes', 'out_of_bed_count', 'remsleepduration', 'rr_average', 'rr_max', 'rr_min', 'sleep_latency', 'sleep_score', 'snoring', 'snoringepisodecount', 'total_sleep_time', 'total_timeinbed', 'wakeup_latency', 'wakeupcount', 'wakeupduration', 'waso', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($apnea_hypopnea_index = ArrayHelper::getValue($apiObject, 'apnea_hypopnea_index')) {
            $this->apnea_hypopnea_index = $apnea_hypopnea_index;
        }
        if($asleepduration = ArrayHelper::getValue($apiObject, 'asleepduration')) {
            $this->asleepduration = $asleepduration;
        }
        if($breathing_disturbances_intensity = ArrayHelper::getValue($apiObject, 'breathing_disturbances_intensity')) {
            $this->breathing_disturbances_intensity = $breathing_disturbances_intensity;
        }
        if($deepsleepduration = ArrayHelper::getValue($apiObject, 'deepsleepduration')) {
            $this->deepsleepduration = $deepsleepduration;
        }
        if($durationtosleep = ArrayHelper::getValue($apiObject, 'durationtosleep')) {
            $this->durationtosleep = $durationtosleep;
        }
        if($durationtowakeup = ArrayHelper::getValue($apiObject, 'durationtowakeup')) {
            $this->durationtowakeup = $durationtowakeup;
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
        if($lightsleepduration = ArrayHelper::getValue($apiObject, 'lightsleepduration')) {
            $this->lightsleepduration = $lightsleepduration;
        }
        if($nb_rem_episodes = ArrayHelper::getValue($apiObject, 'nb_rem_episodes')) {
            $this->nb_rem_episodes = $nb_rem_episodes;
        }
        if($night_events = ArrayHelper::getValue($apiObject, 'night_events')) {
            $this->night_events = $night_events;
        }
        if($out_of_bed_count = ArrayHelper::getValue($apiObject, 'out_of_bed_count')) {
            $this->out_of_bed_count = $out_of_bed_count;
        }
        if($remsleepduration = ArrayHelper::getValue($apiObject, 'remsleepduration')) {
            $this->remsleepduration = $remsleepduration;
        }
        if($rr_average = ArrayHelper::getValue($apiObject, 'rr_average')) {
            $this->rr_average = $rr_average;
        }
        if($rr_max = ArrayHelper::getValue($apiObject, 'rr_max')) {
            $this->rr_max = $rr_max;
        }
        if($rr_min = ArrayHelper::getValue($apiObject, 'rr_min')) {
            $this->rr_min = $rr_min;
        }
        if($sleep_efficiency = ArrayHelper::getValue($apiObject, 'sleep_efficiency')) {
            $this->sleep_efficiency = $sleep_efficiency;
        }
        if($sleep_latency = ArrayHelper::getValue($apiObject, 'sleep_latency')) {
            $this->sleep_latency = $sleep_latency;
        }
        if($sleep_score = ArrayHelper::getValue($apiObject, 'sleep_score')) {
            $this->sleep_score = $sleep_score;
        }
        if($snoring = ArrayHelper::getValue($apiObject, 'snoring')) {
            $this->snoring = $snoring;
        }
        if($snoringepisodecount = ArrayHelper::getValue($apiObject, 'snoringepisodecount')) {
            $this->snoringepisodecount = $snoringepisodecount;
        }
        if($total_sleep_time = ArrayHelper::getValue($apiObject, 'total_sleep_time')) {
            $this->total_sleep_time = $total_sleep_time;
        }
        if($total_timeinbed = ArrayHelper::getValue($apiObject, 'total_timeinbed')) {
            $this->total_timeinbed = $total_timeinbed;
        }
        if($wakeup_latency = ArrayHelper::getValue($apiObject, 'wakeup_latency')) {
            $this->wakeup_latency = $wakeup_latency;
        }
        if($wakeupcount = ArrayHelper::getValue($apiObject, 'wakeupcount')) {
            $this->wakeupcount = $wakeupcount;
        }
        if($wakeupduration = ArrayHelper::getValue($apiObject, 'wakeupduration')) {
            $this->wakeupduration = $wakeupduration;
        }
        if($waso = ArrayHelper::getValue($apiObject, 'waso')) {
            $this->waso = $waso;
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
