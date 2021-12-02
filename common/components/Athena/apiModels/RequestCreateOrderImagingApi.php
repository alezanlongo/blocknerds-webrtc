<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $diagnosissnomedcode The SNOMED code for diagnosis this order is for.
 * @property int $facilityid The athena ID of the imaging center you want to send the order to. Get a localized list using /chart/configuration/facilities.
 * @property string $facilitynote A note to send to the imaging center.
 * @property string $futuresubmitdate The date the order should be sent. Defaults to today.
 * @property bool $highpriority If true, then the order should be sent STAT.
 * @property int $ordertypeid The athena ID of the imaging study to order. Get the IDs using /reference/order/imaging.
 * @property string $providernote An internal note for the provider or staff.
 */
class RequestCreateOrderImagingApi extends BaseApiModel
{

    public $diagnosissnomedcode;
    public $facilityid;
    public $facilitynote;
    public $futuresubmitdate;
    public $highpriority;
    public $ordertypeid;
    public $providernote;

    public function rules()
    {
        return [
            [['facilitynote', 'futuresubmitdate', 'providernote'], 'trim'],
            [['diagnosissnomedcode', 'ordertypeid'], 'required'],
            [['facilitynote', 'futuresubmitdate', 'providernote'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
