<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property LabResult $labResult
 * @property string $abnormalflag The level of normality for this result.
 * @property int $analyteid The athena ID for this analyte. Used to update the analyte.
 * @property string $analytename The name / identifier text for this analyte.
 * @property string $loinc The LOINC code for this analyte
 * @property string $note Any additional notes about this analyte.
 * @property string $observationidentifier The local lab ID for this analyte.
 * @property string $referencerange The normal range for this lab analyte.
 * @property string $resultstatus Whether this observation is a prelimary, corrected, final, etc result.
 * @property string $units The units the value is in.
 * @property string $value The observation value for this analyte.
 */
class ObservationLabResultApi extends BaseApiModel
{

    public $labResult;
    public $abnormalflag;
    public $analyteid;
    public $analytename;
    public $loinc;
    public $note;
    public $observationidentifier;
    public $referencerange;
    public $resultstatus;
    public $units;
    public $value;

    public function rules()
    {
        return [
            [['abnormalflag', 'analytename', 'loinc', 'note', 'observationidentifier', 'referencerange', 'resultstatus', 'units', 'value'], 'trim'],
            [['abnormalflag', 'analytename', 'loinc', 'note', 'observationidentifier', 'referencerange', 'resultstatus', 'units', 'value'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
