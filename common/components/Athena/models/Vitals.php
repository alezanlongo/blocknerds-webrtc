<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property integer $encounterVital_id
 * @property EncounterVitals $encounterVital
 * @property string $abbreviation Short human-readable string for this vital group. E.g., Ht.
 * @property string $key Key for this vital group. E.g., HEIGHT.
 * @property int $ordering Configured order for this vital group
 * @property string $clinicalelementid Key used to identify this particular vital attribute
 * @property string $code Code indentifier for the reading.
 * @property string $codedescription Description of the code identifier.
 * @property string $codeset Codeset of the code.
 * @property string $createdby The athenaNet username of the person who entered the vital.
 * @property string $createddate The date this vital was entered into the chart. Returned in mm/dd/yyyy hh24:mi:ss format.
 * @property string $isgraphable Flag indicating if this vital is graphable.
 * @property object $percentilespec
 * @property int $readingid Numeric key used to tie related and distinguish separate readings. So the diastolic and systolic blood pressure should have the same readingid.
 * @property string $readingtaken Date that the reading was taken.
 * @property string $source The source of this reading.
 * @property int $sourceid External key to source.
 * @property string $unit Unit that describes this vital's value.
 * @property string $value The value of this reading. NOTE: for numeric values, the units are always in the 'native' units per the configuration.
 * @property int $vitalid Unique ID for this vital attribute reading. Used to update/delete this reading.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Vitals extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%vitals}}';
    }

    public function rules()
    {
        return [
            [['abbreviation', 'key', 'clinicalelementid', 'code', 'codedescription', 'codeset', 'createdby', 'createddate', 'isgraphable', 'readingtaken', 'source', 'unit', 'value'], 'trim'],
            [['abbreviation', 'key', 'clinicalelementid', 'code', 'codedescription', 'codeset', 'createdby', 'createddate', 'isgraphable', 'readingtaken', 'source', 'unit', 'value'], 'string'],
            [['encounterVital_id', 'ordering', 'readingid', 'sourceid', 'vitalid', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getEncounterVital()
    {
        return $this->hasOne(EncounterVitals::class, ['id' => 'encounterVital_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($encounterVital_id = ArrayHelper::getValue($apiObject, 'encounterVital_id')) {
            $this->encounterVital_id = $encounterVital_id;
        }
        if($encounterVital = ArrayHelper::getValue($apiObject, 'encounterVital')) {
            $this->encounterVital = $encounterVital;
        }
        if($abbreviation = ArrayHelper::getValue($apiObject, 'abbreviation')) {
            $this->abbreviation = $abbreviation;
        }
        if($key = ArrayHelper::getValue($apiObject, 'key')) {
            $this->key = $key;
        }
        if($ordering = ArrayHelper::getValue($apiObject, 'ordering')) {
            $this->ordering = $ordering;
        }
        if($clinicalelementid = ArrayHelper::getValue($apiObject, 'clinicalelementid')) {
            $this->clinicalelementid = $clinicalelementid;
        }
        if($code = ArrayHelper::getValue($apiObject, 'code')) {
            $this->code = $code;
        }
        if($codedescription = ArrayHelper::getValue($apiObject, 'codedescription')) {
            $this->codedescription = $codedescription;
        }
        if($codeset = ArrayHelper::getValue($apiObject, 'codeset')) {
            $this->codeset = $codeset;
        }
        if($createdby = ArrayHelper::getValue($apiObject, 'createdby')) {
            $this->createdby = $createdby;
        }
        if($createddate = ArrayHelper::getValue($apiObject, 'createddate')) {
            $this->createddate = $createddate;
        }
        if($isgraphable = ArrayHelper::getValue($apiObject, 'isgraphable')) {
            $this->isgraphable = $isgraphable;
        }
        if($percentilespec = ArrayHelper::getValue($apiObject, 'percentilespec')) {
            $this->percentilespec = $percentilespec;
        }
        if($readingid = ArrayHelper::getValue($apiObject, 'readingid')) {
            $this->readingid = $readingid;
        }
        if($readingtaken = ArrayHelper::getValue($apiObject, 'readingtaken')) {
            $this->readingtaken = $readingtaken;
        }
        if($source = ArrayHelper::getValue($apiObject, 'source')) {
            $this->source = $source;
        }
        if($sourceid = ArrayHelper::getValue($apiObject, 'sourceid')) {
            $this->sourceid = $sourceid;
        }
        if($unit = ArrayHelper::getValue($apiObject, 'unit')) {
            $this->unit = $unit;
        }
        if($value = ArrayHelper::getValue($apiObject, 'value')) {
            $this->value = $value;
        }
        if($vitalid = ArrayHelper::getValue($apiObject, 'vitalid')) {
            $this->vitalid = $vitalid;
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
