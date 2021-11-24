<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $findingname The name of the finding.
 * @property string $findingnote The note for the finding selected.
 * @property string $findingtype Describes the finding - either NORMAL, ABNORMAL, or NEUTRAL.
 * @property string $freetext Freetext that could be associated with this finding.
 * @property array $selectedoptions The option in the finding that was selected by the user.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Finding extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%findings}}';
    }

    public function rules()
    {
        return [
            [['findingname', 'findingnote', 'findingtype', 'freetext'], 'trim'],
            [['findingname', 'findingnote', 'findingtype', 'freetext'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($findingname = ArrayHelper::getValue($apiObject, 'findingname')) {
            $this->findingname = $findingname;
        }
        if($findingnote = ArrayHelper::getValue($apiObject, 'findingnote')) {
            $this->findingnote = $findingnote;
        }
        if($findingtype = ArrayHelper::getValue($apiObject, 'findingtype')) {
            $this->findingtype = $findingtype;
        }
        if($freetext = ArrayHelper::getValue($apiObject, 'freetext')) {
            $this->freetext = $freetext;
        }
        if($selectedoptions = ArrayHelper::getValue($apiObject, 'selectedoptions')) {
            $this->selectedoptions = $selectedoptions;
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
