<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $startdate The starting datetime for the sleep state data.
 * @property int $enddate The end datetime for the sleep data. A single call can span up to 7 days maximum. To cover a wider time range, you will need to perform multiple calls.
 * @property int $state The state of sleeping. Values can be:
 * | Value | Description|
 * |---|---|
 * |0 | Sleep state awake|
 * |1 | Sleep state light|
 * |2 | Sleep state deep|
 * |3 | Sleep state rem|
 * |4 | Sleep manual|
 * |5 | Sleep unspecified|
 * @property string $model Device model. Value can be:
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |Aura Dock | Sleep Monitor|
 * |Aura Sensor | Sleep Monitor|
 * |Aura Sensor V2 | Sleep Monitor|
 * |Pulse | Activity Tracker|
 * |Activite | Activity Tracker|
 * |Activite (Pop, Steel) | Activity Tracker|
 * |Withings Go | Activity Tracker|
 * |Activite Steel HR | Activity Tracker|
 * |Activite Steel HR Sport Edition | Activity Tracker|
 * |Pulse HR | Activity Tracker|
 * |Move | Activity Tracker|
 * |Move ECG | Activity Tracker|
 * |ScanWatch | Activity Tracker|
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
 * @property int $hash_deviceid
 * @property sleep_get_series_hr[] $hr Heart Rate. *(Use 'data_fields' to request this data.)*
 * @property sleep_get_series_rr[] $rr Respiration Rate. *(Use 'data_fields' to request this data.)*
 * @property sleep_get_series_snoring[] $snoring Total snoring time
 * @property sleep_get $sleep_get Response data.
 */
class sleep_get_seriesApi extends BaseApiModel
{

    public $startdate;
    public $enddate;
    public $state;
    public $model;
    public $model_id;
    public $hash_deviceid;
    public $hr;
 
    protected $_hrAr;
    public $rr;
 
    protected $_rrAr;
    public $snoring;
 
    protected $_snoringAr;
    public $sleep_get;

    public function rules()
    {
        return [
            [['model'], 'trim'],
            [['model'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->hr) && is_array($this->hr)) {
            foreach($this->hr as $hr) {
                $this->_hrAr[] = new sleep_get_series_hrApi($hr);
            }
            $this->hr = $this->_hrAr;
            $this->_hrAr = [];//CHECKME
        }
        if (!empty($this->rr) && is_array($this->rr)) {
            foreach($this->rr as $rr) {
                $this->_rrAr[] = new sleep_get_series_rrApi($rr);
            }
            $this->rr = $this->_rrAr;
            $this->_rrAr = [];//CHECKME
        }
        if (!empty($this->snoring) && is_array($this->snoring)) {
            foreach($this->snoring as $snoring) {
                $this->_snoringAr[] = new sleep_get_series_snoringApi($snoring);
            }
            $this->snoring = $this->_snoringAr;
            $this->_snoringAr = [];//CHECKME
        }
    }

}
