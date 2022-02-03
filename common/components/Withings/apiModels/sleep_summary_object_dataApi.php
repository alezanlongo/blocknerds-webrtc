<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Details of sleep.
 *
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
 */
class sleep_summary_object_dataApi extends BaseApiModel
{

    public $apnea_hypopnea_index;
    public $asleepduration;
    public $breathing_disturbances_intensity;
    public $deepsleepduration;
    public $durationtosleep;
    public $durationtowakeup;
    public $hr_average;
    public $hr_max;
    public $hr_min;
    public $lightsleepduration;
    public $nb_rem_episodes;
    public $night_events;
    public $out_of_bed_count;
    public $remsleepduration;
    public $rr_average;
    public $rr_max;
    public $rr_min;
    public $sleep_efficiency;
    public $sleep_latency;
    public $sleep_score;
    public $snoring;
    public $snoringepisodecount;
    public $total_sleep_time;
    public $total_timeinbed;
    public $wakeup_latency;
    public $wakeupcount;
    public $wakeupduration;
    public $waso;

    public function rules()
    {
        return [
            [['night_events'], 'trim'],
            [['night_events'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
