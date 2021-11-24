<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property bool $PATIENTFACINGCALL When 'true' is passed we will collect relevant data and store in our database.
 * @property string $THIRDPARTYUSERNAME User name of the patient in the third party application.
 * @property int $departmentid The athenaNet department id.
 * @property string $laterality Update the laterality of this problem. Can be null, LEFT, RIGHT, or BILATERAL.
 * @property string $note The note to be attached to this problem.
 * @property int $snomedcode The <a href="http://www.nlm.nih.gov/research/umls/Snomed/snomed_browsers.html">SNOMED code</a> of the problem you are adding.
 * @property string $startdate The onset date to be updated for this problem in MM/DD/YYYY format.
 * @property string $status Whether the problem is chronic or acute.
 */
class RequestCreateProblemApi extends BaseApiModel
{

    public $PATIENTFACINGCALL;
    public $THIRDPARTYUSERNAME;
    public $departmentid;
    public $laterality;
    public $note;
    public $snomedcode;
    public $startdate;
    public $status;

    public function rules()
    {
        return [
            [['THIRDPARTYUSERNAME', 'laterality', 'note', 'startdate', 'status'], 'trim'],
            [['departmentid', 'snomedcode'], 'required'],
            [['THIRDPARTYUSERNAME', 'laterality', 'note', 'startdate', 'status'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
