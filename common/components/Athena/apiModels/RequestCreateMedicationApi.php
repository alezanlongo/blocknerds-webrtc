<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property bool $PATIENTFACINGCALL When 'true' is passed we will collect relevant data and store in our database.
 * @property string $THIRDPARTYUSERNAME User name of the patient in the third party application.
 * @property int $departmentid The athenanet department ID
 * @property bool $hidden Set whether the medication is hidden in the UI.
 * @property int $medicationid The athena medication ID
 * @property string $patientnote A patient-facing note
 * @property string $providernote An internal note
 * @property string $startdate Start date for this medication
 * @property string $stopdate Stop date for this medication
 * @property string $stopreason The reason the medication was stopped. If set, it it recommended but not required that a stop date is also set.
 * @property string $unstructuredsig Can only be used to update historical (entered, downloaded, etc) medications. Will override a structured sig if there is one.
 */
class RequestCreateMedicationApi extends BaseApiModel
{

    public $PATIENTFACINGCALL;
    public $THIRDPARTYUSERNAME;
    public $departmentid;
    public $hidden;
    public $medicationid;
    public $patientnote;
    public $providernote;
    public $startdate;
    public $stopdate;
    public $stopreason;
    public $unstructuredsig;

    public function rules()
    {
        return [
            [['THIRDPARTYUSERNAME', 'patientnote', 'providernote', 'startdate', 'stopdate', 'stopreason', 'unstructuredsig'], 'trim'],
            [['departmentid', 'medicationid'], 'required'],
            [['THIRDPARTYUSERNAME', 'patientnote', 'providernote', 'startdate', 'stopdate', 'stopreason', 'unstructuredsig'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
