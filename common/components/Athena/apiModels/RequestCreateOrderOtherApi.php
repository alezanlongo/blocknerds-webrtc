<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $diagnosissnomedcode The SNOMED code for diagnosis this order is for.
 * @property int $facilityid The athena ID of the facility you want to send the order to. Get a localized list using /chart/configuration/facilities.
 * @property string $facilitynote A note to send to the facility.
 * @property bool $highpriority If true, then the order should be sent STAT.
 * @property int $ordertypeid The athena ID of the type of order. Get the IDs using /reference/order/other.
 * @property string $providernote An internal note for the provider or staff.
 */
class RequestCreateOrderOtherApi extends BaseApiModel
{

    public $diagnosissnomedcode;
    public $facilityid;
    public $facilitynote;
    public $highpriority;
    public $ordertypeid;
    public $providernote;

    public function rules()
    {
        return [
            [['facilitynote', 'providernote'], 'trim'],
            [['diagnosissnomedcode', 'ordertypeid'], 'required'],
            [['facilitynote', 'providernote'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
