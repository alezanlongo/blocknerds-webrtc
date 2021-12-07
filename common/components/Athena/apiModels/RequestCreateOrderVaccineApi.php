<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $administernote An additional note to the provider or staff for administration.
 * @property string $declineddate The date on which the patient declined the vaccine. Required if the declined reason is passed in.
 * @property int $declinedreason To get a list of decline reasons for this input, call "GET /reference/order/vaccine/declinedreasons"
 * @property int $diagnosissnomedcode The SNOMED code for diagnosis this order is for.
 * @property bool $dispenseaswritten Whether the vaccine prescription should be marked as dispense as written (i.e., no substitutions without consulting the doctor).
 * @property string $facilityid The athena id of the pharmacy you want to send the vaccine prescription to. Defaults to the patient default pharmacy. Get a localized list using /chart/configuration/facilities.
 * @property string $ndc The National Drug Code for the vaccine.
 * @property int $numrefillsallowed The number of refills allowed for this vaccine prescription. Defaults to 0.
 * @property string $orderingmode Selects whether you wish to prescribe, administer, or decline this vaccine.
 * @property int $ordertypeid The athena ID of the vaccine to order. Must be an orderable vaccine. Get the IDs using /reference/order/vaccine
 * @property string $performondate The date on which the Vaccine was administered.
 * @property string $pharmacynote A note to send to the pharmacy.
 * @property string $providernote An internal note for the provider or staff.
 * @property float $totalquantity The total amount of vaccine to be prescribed.
 * @property string $totalquantityunit The unit of the total quantity, and required if that is passed in. Get the list of available values from /reference/order/vaccine/totalquantityunits. Most values are not valid for each individual vaccine.
 * @property string $unstructuredsig The unstructured sig.
 */
class RequestCreateOrderVaccineApi extends BaseApiModel
{

    public $administernote;
    public $declineddate;
    public $declinedreason;
    public $diagnosissnomedcode;
    public $dispenseaswritten;
    public $facilityid;
    public $ndc;
    public $numrefillsallowed;
    public $orderingmode;
    public $ordertypeid;
    public $performondate;
    public $pharmacynote;
    public $providernote;
    public $totalquantity;
    public $totalquantityunit;
    public $unstructuredsig;

    public function rules()
    {
        return [
            [['administernote', 'declineddate', 'facilityid', 'ndc', 'orderingmode', 'performondate', 'pharmacynote', 'providernote', 'totalquantityunit', 'unstructuredsig'], 'trim'],
            [['diagnosissnomedcode', 'ordertypeid'], 'required'],
            [['administernote', 'declineddate', 'facilityid', 'ndc', 'orderingmode', 'performondate', 'pharmacynote', 'providernote', 'totalquantityunit', 'unstructuredsig'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
