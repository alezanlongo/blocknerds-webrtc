<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
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
 * @property Encounter $encounter
 */
class DiagnosesApi extends BaseApiModel
{

    public $description;
    public $diagnosisid;
    public $errormessage;
    public $icdcodes;
 
    protected $_icdcodesAr;
    public $laterality;
    public $note;
    public $ranking;
    public $snomedcode;
    public $success;
    public $supportslaterality;
    public $encounter;

    public function rules()
    {
        return [
            [['description', 'errormessage', 'laterality', 'note', 'success', 'supportslaterality'], 'trim'],
            [['description', 'errormessage', 'laterality', 'note', 'success', 'supportslaterality'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->icdcodes) && is_array($this->icdcodes)) {
            foreach($this->icdcodes as $icdcodes) {
                $this->_icdcodesAr[] = new ICDCodesApi($icdcodes);
            }
            $this->icdcodes = $this->_icdcodesAr;
            $this->_icdcodesAr = [];//CHECKME
        }
    }

}
