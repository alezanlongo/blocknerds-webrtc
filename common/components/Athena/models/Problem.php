<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property integer $patient_id
 * @property Patient $patient
 * @property string $bestmatchicd10code If this was added from the chart or from an encounter without a selected ICD10 code, and if the primary codeset is SNOMED, then this contains the best matching ICD10 code mapped. Because SNOMED to ICD10 is a many to many map, this will tend to give the most generic diagnosis.
 * @property string $code Problem code
 * @property string $codeset Problem codeset (SNOMED, ICD9, ICD10, etc)
 * @property string $deactivateddate Date of problem deactivation.
 * @property string $deactivateduser The name of the user who deactivated the problem.
 * @property Event[] $events List of start and stop events for this problem, which can occur multiple times.
 * @property string $lastmodifiedby The username of the user who last modified this problem.
 * @property string $lastmodifieddatetime The date the problem was last modified. Currently only date precision.
 * @property string $mostrecentdiagnosisnote The data will be displayed when the showdiagnosisinfo flag is set to true
 * @property string $name Problem name
 * @property int $problemid Athena ID for this problem
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Problem extends \yii\db\ActiveRecord
{
 
    protected $_eventsAr;

    public static function tableName()
    {
        return '{{%problems}}';
    }

    public function rules()
    {
        return [
            [['bestmatchicd10code', 'code', 'codeset', 'deactivateddate', 'deactivateduser', 'lastmodifiedby', 'lastmodifieddatetime', 'mostrecentdiagnosisnote', 'name'], 'trim'],
            [['bestmatchicd10code', 'code', 'codeset', 'deactivateddate', 'deactivateduser', 'lastmodifiedby', 'lastmodifieddatetime', 'mostrecentdiagnosisnote', 'name'], 'string'],
            [['patient_id', 'problemid', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }

    public function getEvents()
    {
        return $this->hasMany(Event::class, ['problem_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($patient_id = ArrayHelper::getValue($apiObject, 'patient_id')) {
            $this->patient_id = $patient_id;
        }
        if($patient = ArrayHelper::getValue($apiObject, 'patient')) {
            $this->patient = $patient;
        }
        if($bestmatchicd10code = ArrayHelper::getValue($apiObject, 'bestmatchicd10code')) {
            $this->bestmatchicd10code = $bestmatchicd10code;
        }
        if($code = ArrayHelper::getValue($apiObject, 'code')) {
            $this->code = $code;
        }
        if($codeset = ArrayHelper::getValue($apiObject, 'codeset')) {
            $this->codeset = $codeset;
        }
        if($deactivateddate = ArrayHelper::getValue($apiObject, 'deactivateddate')) {
            $this->deactivateddate = $deactivateddate;
        }
        if($deactivateduser = ArrayHelper::getValue($apiObject, 'deactivateduser')) {
            $this->deactivateduser = $deactivateduser;
        }
        if($events = ArrayHelper::getValue($apiObject, 'events')) {
            $this->_eventsAr = $events;
        }
        if($lastmodifiedby = ArrayHelper::getValue($apiObject, 'lastmodifiedby')) {
            $this->lastmodifiedby = $lastmodifiedby;
        }
        if($lastmodifieddatetime = ArrayHelper::getValue($apiObject, 'lastmodifieddatetime')) {
            $this->lastmodifieddatetime = $lastmodifieddatetime;
        }
        if($mostrecentdiagnosisnote = ArrayHelper::getValue($apiObject, 'mostrecentdiagnosisnote')) {
            $this->mostrecentdiagnosisnote = $mostrecentdiagnosisnote;
        }
        if($name = ArrayHelper::getValue($apiObject, 'name')) {
            $this->name = $name;
        }
        if($problemid = ArrayHelper::getValue($apiObject, 'problemid')) {
            $this->problemid = $problemid;
        }
        if($problemid = ArrayHelper::getValue($apiObject, 'problemid')) {
            $this->externalId = $problemid;
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
        if( !empty($this->_eventsAr) and is_array($this->_eventsAr) ) {
            foreach($this->_eventsAr as $eventsApi) {
                $event = new Event();
                $event->loadApiObject($eventsApi);
                $event->link('problem', $this);
                $event->save();
            }
        }

        return $saved;
    }
    */
}
