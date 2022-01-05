<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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
 * @property integer $data_id Details of sleep.
 * @property sleep_summary_object_data $data Details of sleep.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class sleep_summary_object extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%sleep_summary_objects}}';
    }

    public function rules()
    {
        return [
            [['timezone', 'date'], 'trim'],
            [['timezone', 'date'], 'string'],
            [['model', 'model_id', 'startdate', 'enddate', 'created', 'modified', 'data_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getData()
    {
        return $this->hasOne(sleep_summary_object_data::class, ['id' => 'data_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

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
        if($data_id = ArrayHelper::getValue($apiObject, 'data_id')) {
            $this->data_id = $data_id;
        }
        if($data = ArrayHelper::getValue($apiObject, 'data')) {
            $this->data = $data;
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
