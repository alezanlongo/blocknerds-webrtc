<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $reactionname Name of the reaction.
 * @property string $severity Severity of the reaction.
 * @property int $severitysnomedcode SNOMED code for the severity of this reaction.
 * @property int $snomedcode SNOMED code for this reaction.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Reaction extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%reactions}}';
    }

    public function rules()
    {
        return [
            [['reactionname', 'severity'], 'trim'],
            [['reactionname', 'severity'], 'string'],
            [['severitysnomedcode', 'snomedcode', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($reactionname = ArrayHelper::getValue($apiObject, 'reactionname')) {
            $this->reactionname = $reactionname;
        }
        if($severity = ArrayHelper::getValue($apiObject, 'severity')) {
            $this->severity = $severity;
        }
        if($severitysnomedcode = ArrayHelper::getValue($apiObject, 'severitysnomedcode')) {
            $this->severitysnomedcode = $severitysnomedcode;
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
