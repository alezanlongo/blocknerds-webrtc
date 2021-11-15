<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $lastmodifiedby The username of the user who last modified the note, no known problems checkbox, or problems.
 * @property string $lastmodifieddatetime The date and time the note, no known problems checkbox, or problems were last updated.
 * @property string $lastupdated Deprecated, used LASTMODIFIEDDATETIME instead. The last date any of the problems in the returned list were updated. Does not include no known problems or the section note, and is date precision.
 * @property string $noknownproblems Whether the no known problems checkbox is checked. This is an explicit statement separate from a patient who has no documented problems so far.
 * @property string $notelastmodifiedby The username of the user who last modified the note.
 * @property string $notelastmodifieddatetime The date and time the section note was last updated.
 * @property Problem[] $problems List of problems, grouped by problem code
 * @property string $sectionnote The problem section note
 * @property int $totalcount Total number of problems
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class GetProblem200Response extends \yii\db\ActiveRecord
{
 
    protected $_problemsAr;

    public static function tableName()
    {
        return '{{%get_problem200_responses}}';
    }

    public function rules()
    {
        return [
            [['lastmodifiedby', 'lastmodifieddatetime', 'lastupdated', 'noknownproblems', 'notelastmodifiedby', 'notelastmodifieddatetime', 'sectionnote'], 'trim'],
            [['lastmodifiedby', 'lastmodifieddatetime', 'lastupdated', 'noknownproblems', 'notelastmodifiedby', 'notelastmodifieddatetime', 'sectionnote'], 'string'],
            [['totalcount', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getProblems()
    {
        return $this->hasMany(Problem::class, ['get_problem200_response_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($lastmodifiedby = ArrayHelper::getValue($apiObject, 'lastmodifiedby')) {
            $this->lastmodifiedby = $lastmodifiedby;
        }
        if($lastmodifieddatetime = ArrayHelper::getValue($apiObject, 'lastmodifieddatetime')) {
            $this->lastmodifieddatetime = $lastmodifieddatetime;
        }
        if($lastupdated = ArrayHelper::getValue($apiObject, 'lastupdated')) {
            $this->lastupdated = $lastupdated;
        }
        if($noknownproblems = ArrayHelper::getValue($apiObject, 'noknownproblems')) {
            $this->noknownproblems = $noknownproblems;
        }
        if($notelastmodifiedby = ArrayHelper::getValue($apiObject, 'notelastmodifiedby')) {
            $this->notelastmodifiedby = $notelastmodifiedby;
        }
        if($notelastmodifieddatetime = ArrayHelper::getValue($apiObject, 'notelastmodifieddatetime')) {
            $this->notelastmodifieddatetime = $notelastmodifieddatetime;
        }
        if($problems = ArrayHelper::getValue($apiObject, 'problems')) {
            $this->_problemsAr = $problems;
        }
        if($sectionnote = ArrayHelper::getValue($apiObject, 'sectionnote')) {
            $this->sectionnote = $sectionnote;
        }
        if($totalcount = ArrayHelper::getValue($apiObject, 'totalcount')) {
            $this->totalcount = $totalcount;
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
        if( !empty($this->_problemsAr) and is_array($this->_problemsAr) ) {
            foreach($this->_problemsAr as $problemsApi) {
                $problem = new Problem();
                $problem->loadApiObject($problemsApi);
                $problem->link('getProblem200Response', $this);
                $problem->save();
            }
        }

        return $saved;
    }
    */
}
