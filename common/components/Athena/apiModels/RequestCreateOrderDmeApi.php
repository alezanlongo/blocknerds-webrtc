<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $diagnosissnomedcode The SNOMED code for diagnosis this order is for.
 * @property bool $dispenseaswritten Whether the DME should be marked as dispense as written (i.e., no substitutions without consulting the doctor).
 * @property string $facilityid The athena id of the supplier you want to send the prescription to. Defaults to the patient default supplier. Get a localized list using /chart/configuration/facilities.
 * @property string $facilitynote A note to send to the supplying facility.
 * @property int $numrefillsallowed The number of refills allowed for this DME. Defaults to 0.
 * @property string $orderingmode Selects whether you wish to prescribe, or dispense this DME.
 * @property int $ordertypeid The athena ID of the DME to order. Get the IDs using /reference/order/dme
 * @property string $providernote An internal note for the provider or staff.
 * @property float $totalquantity The total amount of units of the DME being prescribed.
 * @property string $unstructuredsig The unstructured sig.
 */
class RequestCreateOrderDmeApi extends BaseApiModel
{

    public $diagnosissnomedcode;
    public $dispenseaswritten;
    public $facilityid;
    public $facilitynote;
    public $numrefillsallowed;
    public $orderingmode;
    public $ordertypeid;
    public $providernote;
    public $totalquantity;
    public $unstructuredsig;

    public function rules()
    {
        return [
            [['facilityid', 'facilitynote', 'orderingmode', 'providernote', 'unstructuredsig'], 'trim'],
            [['diagnosissnomedcode', 'ordertypeid'], 'required'],
            [['facilityid', 'facilitynote', 'orderingmode', 'providernote', 'unstructuredsig'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
