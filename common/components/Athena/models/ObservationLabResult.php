<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property integer $labResult_id
 * @property LabResult $labResult
 * @property string $abnormalflag The level of normality for this result.
 * @property int $analyteid The athena ID for this analyte. Used to update the analyte.
 * @property string $analytename The name / identifier text for this analyte.
 * @property string $loinc The LOINC code for this analyte
 * @property string $note Any additional notes about this analyte.
 * @property string $observationidentifier The local lab ID for this analyte.
 * @property string $referencerange The normal range for this lab analyte.
 * @property string $resultstatus Whether this observation is a prelimary, corrected, final, etc result.
 * @property string $units The units the value is in.
 * @property string $value The observation value for this analyte.
 * @property string $externalId API Primary Key
 * @property integer $id Primary Key
 */
class ObservationLabResult extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%observation_lab_results}}';
    }

    public function rules()
    {
        return [
            [['abnormalflag', 'analytename', 'loinc', 'note', 'observationidentifier', 'referencerange', 'resultstatus', 'units', 'value', 'externalId'], 'trim'],
            [['abnormalflag', 'analytename', 'loinc', 'note', 'observationidentifier', 'referencerange', 'resultstatus', 'units', 'value', 'externalId'], 'string'],
            [['labResult_id', 'analyteid', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getLabResult()
    {
        return $this->hasOne(LabResult::class, ['id' => 'labResult_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($labResult_id = ArrayHelper::getValue($apiObject, 'labResult_id')) {
            $this->labResult_id = $labResult_id;
        }
        if($labResult = ArrayHelper::getValue($apiObject, 'labResult')) {
            $this->labResult = $labResult;
        }
        if($abnormalflag = ArrayHelper::getValue($apiObject, 'abnormalflag')) {
            $this->abnormalflag = $abnormalflag;
        }
        if($analyteid = ArrayHelper::getValue($apiObject, 'analyteid')) {
            $this->analyteid = $analyteid;
        }
        if($analytename = ArrayHelper::getValue($apiObject, 'analytename')) {
            $this->analytename = $analytename;
        }
        if($loinc = ArrayHelper::getValue($apiObject, 'loinc')) {
            $this->loinc = $loinc;
        }
        if($note = ArrayHelper::getValue($apiObject, 'note')) {
            $this->note = $note;
        }
        if($observationidentifier = ArrayHelper::getValue($apiObject, 'observationidentifier')) {
            $this->observationidentifier = $observationidentifier;
        }
        if($observationidentifier = ArrayHelper::getValue($apiObject, 'observationidentifier')) {
            $this->externalId = $observationidentifier;
        }
        if($referencerange = ArrayHelper::getValue($apiObject, 'referencerange')) {
            $this->referencerange = $referencerange;
        }
        if($resultstatus = ArrayHelper::getValue($apiObject, 'resultstatus')) {
            $this->resultstatus = $resultstatus;
        }
        if($units = ArrayHelper::getValue($apiObject, 'units')) {
            $this->units = $units;
        }
        if($value = ArrayHelper::getValue($apiObject, 'value')) {
            $this->value = $value;
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
