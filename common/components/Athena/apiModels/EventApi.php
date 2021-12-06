<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property Problem $problem
 * @property string $createdby The name of the user who entered this problem.
 * @property string $createddate The date that the user entered this problem.
 * @property EventDiagnose[] $diagnoses List of encounter diagnoses that triggered this problem.
 * @property string $encounterdate The date of the encounter where a diagnosis matching this problem was used.
 * @property string $enddate The date this problem event ended or was hidden
 * @property string $eventtype The type of this event: START, END, HIDDEN, REACTIVATED, or ENCOUNTER
 * @property string $laterality The laterality of this problem. Can be null, LEFT, RIGHT, or BILATERAL.
 * @property string $note The note attached to this event.
 * @property string $onsetdate The specified onset date for this problem, as entered by the practice. If available this is more accurate than the start date.
 * @property string $source The source of this event: ENCOUNTER or HISTORY
 * @property string $startdate The date this problem event started or was restarted. Uses the onsetdate if available, otherwise uses the date the problem was entered into the system.
 * @property string $status The status of this problem event: CHRONIC or ACUTE
 */
class EventApi extends BaseApiModel
{

    public $problem;
    public $createdby;
    public $createddate;
    public $diagnoses;
 
    protected $_diagnosesAr;
    public $encounterdate;
    public $enddate;
    public $eventtype;
    public $laterality;
    public $note;
    public $onsetdate;
    public $source;
    public $startdate;
    public $status;

    public function rules()
    {
        return [
            [['createdby', 'createddate', 'encounterdate', 'enddate', 'eventtype', 'laterality', 'note', 'onsetdate', 'source', 'startdate', 'status'], 'trim'],
            [['createdby', 'createddate', 'encounterdate', 'enddate', 'eventtype', 'laterality', 'note', 'onsetdate', 'source', 'startdate', 'status'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->diagnoses) && is_array($this->diagnoses)) {
            foreach($this->diagnoses as $diagnoses) {
                $this->_diagnosesAr[] = new EventDiagnoseApi($diagnoses);
            }
            $this->diagnoses = $this->_diagnosesAr;
            $this->_diagnosesAr = [];//CHECKME
        }
    }

}
