<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $startdate The starting datetime for the sleep state data.
 * @property int $enddate The end datetime for the sleep data. A single call can span up to 7 days maximum. To cover a wider time range, you will need to perform multiple calls.
 * @property int $state The state of sleeping. Values can be:
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |0 | Sleep state awake|
 * |1 | Sleep state light|
 * |2 | Sleep state deep|
 * |3 | Sleep state rem|
 * |4 | Sleep manual|
 * |5 | Sleep unspecified|
 * @property integer $hr_id Heart Rate. *(Use 'data_fields' to request this data.)*
 * @property inline_response_200_16_body_series_hr $hr Heart Rate. *(Use 'data_fields' to request this data.)*
 * @property integer $rr_id Respiration Rate. *(Use 'data_fields' to request this data.)*
 * @property inline_response_200_16_body_series_rr $rr Respiration Rate. *(Use 'data_fields' to request this data.)*
 * @property integer $snoring_id Total snoring time
 * @property inline_response_200_16_body_series_snoring $snoring Total snoring time
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_16_body_series extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_16_body_series}}';
    }

    public function rules()
    {
        return [
            [['startdate', 'enddate', 'state', 'hr_id', 'rr_id', 'snoring_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getHr()
    {
        return $this->hasOne(inline_response_200_16_body_series_hr::class, ['id' => 'hr_id']);
    }

    public function getRr()
    {
        return $this->hasOne(inline_response_200_16_body_series_rr::class, ['id' => 'rr_id']);
    }

    public function getSnoring()
    {
        return $this->hasOne(inline_response_200_16_body_series_snoring::class, ['id' => 'snoring_id']);
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
        if($hr_id = ArrayHelper::getValue($apiObject, 'hr_id')) {
            $this->hr_id = $hr_id;
        }
        if($hr = ArrayHelper::getValue($apiObject, 'hr')) {
            $this->hr = $hr;
        }
        if($rr_id = ArrayHelper::getValue($apiObject, 'rr_id')) {
            $this->rr_id = $rr_id;
        }
        if($rr = ArrayHelper::getValue($apiObject, 'rr')) {
            $this->rr = $rr;
        }
        if($snoring_id = ArrayHelper::getValue($apiObject, 'snoring_id')) {
            $this->snoring_id = $snoring_id;
        }
        if($snoring = ArrayHelper::getValue($apiObject, 'snoring')) {
            $this->snoring = $snoring;
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
