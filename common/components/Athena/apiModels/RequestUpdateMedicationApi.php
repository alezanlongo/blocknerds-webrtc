<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $departmentid The athenanet department ID
 * @property bool $hidden Set whether the medication is hidden in the UI.
 * @property string $patientnote A patient-facing note
 * @property string $providernote An internal note
 * @property string $startdate Start date for this medication
 * @property string $stopdate Stop date for this medication
 * @property string $stopreason The reason the medication was stopped. If set, it it recommended but not required that a stop date is also set.
 * @property string $unstructuredsig Can only be used to update historical (entered, downloaded, etc) medications. Will override a structured sig if there is one.
 */
class RequestUpdateMedicationApi extends BaseApiModel
{

    public $departmentid;
    public $hidden;
    public $patientnote;
    public $providernote;
    public $startdate;
    public $stopdate;
    public $stopreason;
    public $unstructuredsig;

    public function rules()
    {
        return [
            [['patientnote', 'providernote', 'startdate', 'stopdate', 'stopreason', 'unstructuredsig'], 'trim'],
            [['departmentid'], 'required'],
            [['patientnote', 'providernote', 'startdate', 'stopdate', 'stopreason', 'unstructuredsig'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
