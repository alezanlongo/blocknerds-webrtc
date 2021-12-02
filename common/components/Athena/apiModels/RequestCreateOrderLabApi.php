<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $diagnosissnomedcode The SNOMED code for diagnosis this order is for.
 * @property int $facilityid The athena ID of the lab you want to send the order to. Get a localized list using /chart/configuration/facilities.
 * @property string $facilitynote A note to send to the lab.
 * @property string $futuresubmitdate The date the order should be sent. Defaults to today.
 * @property bool $highpriority If true, then the order should be sent STAT.
 * @property string $loinc The LOINC of the lab you wish to order. Either this or ordertypeid can be used, but not both.
 * @property int $ordertypeid The athena ID of the lab to order. Get the IDs using /reference/order/lab. Either this or LOINC can be used, but not both.
 * @property string $providernote An internal note for the provider or staff.
 */
class RequestCreateOrderLabApi extends BaseApiModel
{

    public $diagnosissnomedcode;
    public $facilityid;
    public $facilitynote;
    public $futuresubmitdate;
    public $highpriority;
    public $loinc;
    public $ordertypeid;
    public $providernote;

    public function rules()
    {
        return [
            [['facilitynote', 'futuresubmitdate', 'loinc', 'providernote'], 'trim'],
            [['diagnosissnomedcode'], 'required'],
            [['facilitynote', 'futuresubmitdate', 'loinc', 'providernote'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
