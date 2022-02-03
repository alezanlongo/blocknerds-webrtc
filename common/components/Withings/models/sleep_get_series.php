<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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
 * @property integer $sleep_get_id Response data.
 * @property sleep_get $sleep_get Response data.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class sleep_get_series extends \yii\db\ActiveRecord
{
 
    protected $_hrAr;
 
    protected $_rrAr;
 
    protected $_snoringAr;

    public static function tableName()
    {
        return '{{%wth_sleep_get_series}}';
    }

    public function rules()
    {
        return [
            [['model'], 'trim'],
            [['model'], 'string'],
            [['startdate', 'enddate', 'state', 'model_id', 'hash_deviceid', 'sleep_get_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getHr()
    {
        return $this->hasMany(sleep_get_series_hr::class, ['sleep_get_series_id' => 'id']);
    }

    public function getRr()
    {
        return $this->hasMany(sleep_get_series_rr::class, ['sleep_get_series_id' => 'id']);
    }

    public function getSnoring()
    {
        return $this->hasMany(sleep_get_series_snoring::class, ['sleep_get_series_id' => 'id']);
    }

    public function getSleep_get()
    {
        return $this->hasOne(sleep_get::class, ['id' => 'sleep_get_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($startdate = ArrayHelper::getValue($apiObject, 'startdate')) {
            $this->startdate = $startdate;
        }
        if($enddate = ArrayHelper::getValue($apiObject, 'enddate')) {
            $this->enddate = $enddate;
        }
        if($state = ArrayHelper::getValue($apiObject, 'state')) {
            $this->state = $state;
        }
        if($model = ArrayHelper::getValue($apiObject, 'model')) {
            $this->model = $model;
        }
        if($model_id = ArrayHelper::getValue($apiObject, 'model_id')) {
            $this->model_id = $model_id;
        }
        if($hash_deviceid = ArrayHelper::getValue($apiObject, 'hash_deviceid')) {
            $this->hash_deviceid = $hash_deviceid;
        }
        if($hr = ArrayHelper::getValue($apiObject, 'hr')) {
            $this->_hrAr = $hr;
        }
        if($rr = ArrayHelper::getValue($apiObject, 'rr')) {
            $this->_rrAr = $rr;
        }
        if($snoring = ArrayHelper::getValue($apiObject, 'snoring')) {
            $this->_snoringAr = $snoring;
        }
        if($sleep_get_id = ArrayHelper::getValue($apiObject, 'sleep_get_id')) {
            $this->sleep_get_id = $sleep_get_id;
        }
        if($sleep_get = ArrayHelper::getValue($apiObject, 'sleep_get')) {
            $this->sleep_get = $sleep_get;
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
        if( !empty($this->_hrAr) and is_array($this->_hrAr) ) {
            foreach($this->_hrAr as $hrApi) {
                $sleep_get_series_hr = new sleep_get_series_hr();
                $sleep_get_series_hr->loadApiObject($hrApi);
                $sleep_get_series_hr->link('sleepGetSeries', $this);
                $sleep_get_series_hr->save();
            }
        }
        if( !empty($this->_rrAr) and is_array($this->_rrAr) ) {
            foreach($this->_rrAr as $rrApi) {
                $sleep_get_series_rr = new sleep_get_series_rr();
                $sleep_get_series_rr->loadApiObject($rrApi);
                $sleep_get_series_rr->link('sleepGetSeries', $this);
                $sleep_get_series_rr->save();
            }
        }
        if( !empty($this->_snoringAr) and is_array($this->_snoringAr) ) {
            foreach($this->_snoringAr as $snoringApi) {
                $sleep_get_series_snoring = new sleep_get_series_snoring();
                $sleep_get_series_snoring->loadApiObject($snoringApi);
                $sleep_get_series_snoring->link('sleepGetSeries', $this);
                $sleep_get_series_snoring->save();
            }
        }

        return $saved;
    }
    */
}
