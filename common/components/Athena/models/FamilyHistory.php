<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class FamilyHistory extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%family_histories}}';
    }

    public function rules()
    {
        return [
            [['description', 'note', 'relation'], 'trim'],
            [['description', 'note', 'relation'], 'string'],
            [['diedofage', 'onsetage', 'patientid', 'problemid', 'relationkeyid', 'resolvedage', 'snomedcode', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($description = ArrayHelper::getValue($apiObject, 'description')) {
            $this->description = $description;
        }
        if($diedofage = ArrayHelper::getValue($apiObject, 'diedofage')) {
            $this->diedofage = $diedofage;
        }
        if($note = ArrayHelper::getValue($apiObject, 'note')) {
            $this->note = $note;
        }
        if($onsetage = ArrayHelper::getValue($apiObject, 'onsetage')) {
            $this->onsetage = $onsetage;
        }
        if($patientid = ArrayHelper::getValue($apiObject, 'patientid')) {
            $this->patientid = $patientid;
        }
        if($problemid = ArrayHelper::getValue($apiObject, 'problemid')) {
            $this->problemid = $problemid;
        }
        if($problemid = ArrayHelper::getValue($apiObject, 'problemid')) {
            $this->externalId = $problemid;
        }
        if($relation = ArrayHelper::getValue($apiObject, 'relation')) {
            $this->relation = $relation;
        }
        if($relationkeyid = ArrayHelper::getValue($apiObject, 'relationkeyid')) {
            $this->relationkeyid = $relationkeyid;
        }
        if($resolvedage = ArrayHelper::getValue($apiObject, 'resolvedage')) {
            $this->resolvedage = $resolvedage;
        }
        if($snomedcode = ArrayHelper::getValue($apiObject, 'snomedcode')) {
            $this->snomedcode = $snomedcode;
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
