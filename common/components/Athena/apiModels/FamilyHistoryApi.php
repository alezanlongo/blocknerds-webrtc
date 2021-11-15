<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $description Brief description for this code/problem
 * @property int $diedofage Age when the patient died, if this problem was the cause
 * @property string $note Additional note for this problem
 * @property int $onsetage Age when this problem first occured
 * @property int $patientid The athenanet patient ID associated with this family problem.
 * @property int $problemid Athena ID for this problem
 * @property string $relation Relationship to the patient
 * @property int $relationkeyid ID of the relationship (for example, having 2 brothers, one would have ID of 1, another would have ID of 2)
 * @property int $resolvedage Age when the problem was resolved, if applicable
 * @property int $snomedcode SNOMED code for this diagnosis
 */
class FamilyHistoryApi extends BaseApiModel
{

    public $description;
    public $diedofage;
    public $note;
    public $onsetage;
    public $patientid;
    public $problemid;
    public $relation;
    public $relationkeyid;
    public $resolvedage;
    public $snomedcode;

    public function rules()
    {
        return [
            [['description', 'note', 'relation'], 'trim'],
            [['description', 'note', 'relation'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
