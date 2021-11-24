<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $description Brief description for this SNOMED Code
 * @property int $diagnosisid Athena ID for this diagnosis
 * @property string $errormessage If not successful, will contain error message.
 * @property ICDCodes[] $icdcodes List of relevant ICD codes for this diagnosis
 * @property string $laterality The laterality of the SNOMED Code, if any.
 * @property string $note The note entered for this diagnosis.
 * @property int $ranking Used to specify the position of this diagnosis in the diagnoses section.
 * @property int $snomedcode SNOMED Code for this diagnosis
 * @property string $success True if successful.
 * @property string $supportslaterality If true, then laterality may chosen for the diagnosis.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Diagnoses extends \yii\db\ActiveRecord
{
 
    protected $_icdcodesAr;

    public static function tableName()
    {
        return '{{%diagnoses}}';
    }

    public function rules()
    {
        return [
            [['description', 'errormessage', 'laterality', 'note', 'success', 'supportslaterality'], 'trim'],
            [['description', 'errormessage', 'laterality', 'note', 'success', 'supportslaterality'], 'string'],
            [['diagnosisid', 'ranking', 'snomedcode', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getIcdcodes()
    {
        return $this->hasMany(ICDCodes::class, ['diagnoses_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($description = ArrayHelper::getValue($apiObject, 'description')) {
            $this->description = $description;
        }
        if($diagnosisid = ArrayHelper::getValue($apiObject, 'diagnosisid')) {
            $this->diagnosisid = $diagnosisid;
        }
        if($diagnosisid = ArrayHelper::getValue($apiObject, 'diagnosisid')) {
            $this->externalId = $diagnosisid;
        }
        if($errormessage = ArrayHelper::getValue($apiObject, 'errormessage')) {
            $this->errormessage = $errormessage;
        }
        if($icdcodes = ArrayHelper::getValue($apiObject, 'icdcodes')) {
            $this->_icdcodesAr = $icdcodes;
        }
        if($laterality = ArrayHelper::getValue($apiObject, 'laterality')) {
            $this->laterality = $laterality;
        }
        if($note = ArrayHelper::getValue($apiObject, 'note')) {
            $this->note = $note;
        }
        if($ranking = ArrayHelper::getValue($apiObject, 'ranking')) {
            $this->ranking = $ranking;
        }
        if($snomedcode = ArrayHelper::getValue($apiObject, 'snomedcode')) {
            $this->snomedcode = $snomedcode;
        }
        if($success = ArrayHelper::getValue($apiObject, 'success')) {
            $this->success = $success;
        }
        if($supportslaterality = ArrayHelper::getValue($apiObject, 'supportslaterality')) {
            $this->supportslaterality = $supportslaterality;
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
        if( !empty($this->_icdcodesAr) and is_array($this->_icdcodesAr) ) {
            foreach($this->_icdcodesAr as $icdcodesApi) {
                $icdcodes = new ICDCodes();
                $icdcodes->loadApiObject($icdcodesApi);
                $icdcodes->link('diagnoses', $this);
                $icdcodes->save();
            }
        }

        return $saved;
    }
    */
}
