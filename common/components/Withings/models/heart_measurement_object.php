<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $deviceid ID of device that tracked the data. To retrieve information about this device, refer to : <a href='/api-reference/#operation/userv2-getdevice'>User v2 - Getdevice</a>.
 * @property int $model The source of the recording.
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |44 | BPM Core|
 * |91 | Move ECG|
 * @property integer $ecg_id
 * @property heart_measurement_object_ecg $ecg
 * @property integer $bloodpressure_id
 * @property heart_measurement_object_bloodpressure $bloodpressure
 * @property int $heart_rate Average recorded heart rate.
 * @property int $timestamp Timestamp of the recording.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class heart_measurement_object extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%wth_heart_measurement_objects}}';
    }

    public function rules()
    {
        return [
            [['deviceid'], 'trim'],
            [['deviceid'], 'string'],
            [['model', 'ecg_id', 'bloodpressure_id', 'heart_rate', 'timestamp', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getEcg()
    {
        return $this->hasOne(heart_measurement_object_ecg::class, ['id' => 'ecg_id']);
    }

    public function getBloodpressure()
    {
        return $this->hasOne(heart_measurement_object_bloodpressure::class, ['id' => 'bloodpressure_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($deviceid = ArrayHelper::getValue($apiObject, 'deviceid')) {
            $this->deviceid = $deviceid;
        }
        if($model = ArrayHelper::getValue($apiObject, 'model')) {
            $this->model = $model;
        }
        if($ecg_id = ArrayHelper::getValue($apiObject, 'ecg_id')) {
            $this->ecg_id = $ecg_id;
        }
        if($ecg = ArrayHelper::getValue($apiObject, 'ecg')) {
            $this->ecg = $ecg;
        }
        if($bloodpressure_id = ArrayHelper::getValue($apiObject, 'bloodpressure_id')) {
            $this->bloodpressure_id = $bloodpressure_id;
        }
        if($bloodpressure = ArrayHelper::getValue($apiObject, 'bloodpressure')) {
            $this->bloodpressure = $bloodpressure;
        }
        if($heart_rate = ArrayHelper::getValue($apiObject, 'heart_rate')) {
            $this->heart_rate = $heart_rate;
        }
        if($timestamp = ArrayHelper::getValue($apiObject, 'timestamp')) {
            $this->timestamp = $timestamp;
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
