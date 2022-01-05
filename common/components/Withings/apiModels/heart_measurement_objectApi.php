<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $deviceid ID of device that tracked the data. To retrieve information about this device, refer to : <a href='/api-reference/#operation/userv2-getdevice'>User v2 - Getdevice</a>.
 * @property int $model The source of the recording.
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |44 | BPM Core|
 * |91 | Move ECG|
 * @property heart_measurement_object_ecg $ecg
 * @property heart_measurement_object_bloodpressure $bloodpressure
 * @property int $heart_rate Average recorded heart rate.
 * @property int $timestamp Timestamp of the recording.
 */
class heart_measurement_objectApi extends BaseApiModel
{

    public $deviceid;
    public $model;
    public $ecg;
    public $bloodpressure;
    public $heart_rate;
    public $timestamp;

    public function rules()
    {
        return [
            [['deviceid'], 'trim'],
            [['deviceid'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
