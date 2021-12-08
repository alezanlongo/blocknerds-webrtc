<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $diagnosissnomedcode The SNOMED code for diagnosis this order is for.
 * @property string $externalnote An external note for the patient.
 * @property int $ordertypeid The athena ID of the patient information to order. Get the IDs using /reference/order/patientinfo.
 * @property string $providernote An internal note for the provider or staff.
 */
class RequestCreateOrderPatientInfoApi extends BaseApiModel
{

    public $diagnosissnomedcode;
    public $externalnote;
    public $ordertypeid;
    public $providernote;

    public function rules()
    {
        return [
            [['externalnote', 'providernote'], 'trim'],
            [['diagnosissnomedcode', 'ordertypeid'], 'required'],
            [['externalnote', 'providernote'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
