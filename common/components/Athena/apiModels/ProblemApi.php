<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
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
 */
class ProblemApi extends BaseApiModel
{

    public $patient;
    public $bestmatchicd10code;
    public $code;
    public $codeset;
    public $deactivateddate;
    public $deactivateduser;
    public $events;
 
    protected $_eventsAr;
    public $lastmodifiedby;
    public $lastmodifieddatetime;
    public $mostrecentdiagnosisnote;
    public $name;
    public $problemid;

    public function rules()
    {
        return [
            [['bestmatchicd10code', 'code', 'codeset', 'deactivateddate', 'deactivateduser', 'lastmodifiedby', 'lastmodifieddatetime', 'mostrecentdiagnosisnote', 'name'], 'trim'],
            [['bestmatchicd10code', 'code', 'codeset', 'deactivateddate', 'deactivateduser', 'lastmodifiedby', 'lastmodifieddatetime', 'mostrecentdiagnosisnote', 'name'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->events) && is_array($this->events)) {
            foreach($this->events as $events) {
                $this->_eventsAr[] = new EventApi($events);
            }
            $this->events = $this->_eventsAr;
            $this->_eventsAr = [];//CHECKME
        }
    }

}
