<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
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
 * @property sleep_summary_object_data $data Details of sleep.
 */
class sleep_summary_objectApi extends BaseApiModel
{

    public $timezone;
    public $model;
    public $model_id;
    public $startdate;
    public $enddate;
    public $date;
    public $created;
    public $modified;
    public $data;

    public function rules()
    {
        return [
            [['timezone', 'date'], 'trim'],
            [['timezone', 'date'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
