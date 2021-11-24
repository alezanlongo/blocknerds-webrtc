<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $lastmodifiedby The username of the user who last modified the note, no known problems checkbox, or problems.
 * @property string $lastmodifieddatetime The date and time the note, no known problems checkbox, or problems were last updated.
 * @property string $lastupdated Deprecated, used LASTMODIFIEDDATETIME instead. The last date any of the problems in the returned list were updated. Does not include no known problems or the section note, and is date precision.
 * @property string $noknownproblems Whether the no known problems checkbox is checked. This is an explicit statement separate from a patient who has no documented problems so far.
 * @property string $notelastmodifiedby The username of the user who last modified the note.
 * @property string $notelastmodifieddatetime The date and time the section note was last updated.
 * @property Problem[] $problems List of problems, grouped by problem code
 * @property string $sectionnote The problem section note
 * @property int $totalcount Total number of problems
 */
class GetProblem200ResponseApi extends BaseApiModel
{

    public $lastmodifiedby;
    public $lastmodifieddatetime;
    public $lastupdated;
    public $noknownproblems;
    public $notelastmodifiedby;
    public $notelastmodifieddatetime;
    public $problems;
 
    protected $_problemsAr;
    public $sectionnote;
    public $totalcount;

    public function rules()
    {
        return [
            [['lastmodifiedby', 'lastmodifieddatetime', 'lastupdated', 'noknownproblems', 'notelastmodifiedby', 'notelastmodifieddatetime', 'sectionnote'], 'trim'],
            [['lastmodifiedby', 'lastmodifieddatetime', 'lastupdated', 'noknownproblems', 'notelastmodifiedby', 'notelastmodifieddatetime', 'sectionnote'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->problems) && is_array($this->problems)) {
            foreach($this->problems as $problems) {
                $this->_problemsAr[] = new ProblemApi($problems);
            }
            $this->problems = $this->_problemsAr;
            $this->_problemsAr = [];//CHECKME
        }
    }

}
