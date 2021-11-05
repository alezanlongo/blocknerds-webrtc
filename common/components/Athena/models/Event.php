<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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
 * @property string $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Event extends \yii\db\ActiveRecord
{
 
    protected $_diagnosesAr;

    public static function tableName()
    {
        return '{{%events}}';
    }

    public function rules()
    {
        return [
            [['createdby', 'createddate', 'encounterdate', 'enddate', 'eventtype', 'laterality', 'note', 'onsetdate', 'source', 'startdate', 'status', 'externalId'], 'trim'],
            [['createdby', 'createddate', 'encounterdate', 'enddate', 'eventtype', 'laterality', 'note', 'onsetdate', 'source', 'startdate', 'status', 'externalId'], 'string'],
            [['id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getDiagnoses()
    {
        return $this->hasMany(EventDiagnose::class, ['event_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($createdby = ArrayHelper::getValue($apiObject, 'createdby')) {
            $this->createdby = $createdby;
        }
        if($createddate = ArrayHelper::getValue($apiObject, 'createddate')) {
            $this->createddate = $createddate;
        }
        if($diagnoses = ArrayHelper::getValue($apiObject, 'diagnoses')) {
            $this->_diagnosesAr = $diagnoses;
        }
        if($encounterdate = ArrayHelper::getValue($apiObject, 'encounterdate')) {
            $this->encounterdate = $encounterdate;
        }
        if($enddate = ArrayHelper::getValue($apiObject, 'enddate')) {
            $this->enddate = $enddate;
        }
        if($eventtype = ArrayHelper::getValue($apiObject, 'eventtype')) {
            $this->eventtype = $eventtype;
        }
        if($laterality = ArrayHelper::getValue($apiObject, 'laterality')) {
            $this->laterality = $laterality;
        }
        if($note = ArrayHelper::getValue($apiObject, 'note')) {
            $this->note = $note;
        }
        if($onsetdate = ArrayHelper::getValue($apiObject, 'onsetdate')) {
            $this->onsetdate = $onsetdate;
        }
        if($source = ArrayHelper::getValue($apiObject, 'source')) {
            $this->source = $source;
        }
        if($startdate = ArrayHelper::getValue($apiObject, 'startdate')) {
            $this->startdate = $startdate;
        }
        if($status = ArrayHelper::getValue($apiObject, 'status')) {
            $this->status = $status;
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
        if( !empty($this->_diagnosesAr) and is_array($this->_diagnosesAr) ) {
            foreach($this->_diagnosesAr as $diagnosesApi) {
                $eventdiagnose = new EventDiagnose();
                $eventdiagnose->loadApiObject($diagnosesApi);
                $eventdiagnose->link('event', $this);
                $eventdiagnose->save();
            }
        }

        return $saved;
    }
    */
}
