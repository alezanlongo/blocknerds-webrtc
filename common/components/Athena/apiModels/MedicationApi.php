<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $approvedby For clinical prescriptions, the athenaNet username of the person who approved this prescription.
 * @property string $billingndc The billing NDC code for this medication.
 * @property int $chartsharinggroupid The chart charing group for this medication. For more information on chart sharing groups see /configuration/chartsharinggroups.
 * @property string $createdby The athenaNet username of the person who entered or ordered the medication. Downloaded medications have INTERFACE for this field.
 * @property string $deletedby The athenaNet username of the person who deleted the medication.
 * @property string $earliestfilldate The earliest date a prescription may be filled, in the format mm/dd/yyyy.
 * @property int $encounterid If this was a prescription, this contains the ID of the encounter where it was ordered or administered
 * @property string $futuresubmitdate The date a medication will be submitted. Included if the medication is in PEND status and attached to a approved future order.
 * @property string $issafetorenew
 * @property string $isstructuredsig Whether the sig for this entry is structured.
 * @property string $lastupdated The last time any of the medications were updated
 * @property string $medication The name of the medication.
 * @property string $medicationentryid Primary ID for this medication entry. Those starting with C are clinical prescriptions, and those starting with H are historical (entered, downloaded, etc).
 * @property int $medicationid Athena ID for this medication.
 * @property string $ndcoptions The list of NDC numbers that correspond to this medication.
 * @property string $orderingmode The ordering mode for prescriptions. Can be PRESCRIBE, DISPENSE, or ADMINISTER.
 * @property string $organclass The organ class for this medication. This is equivalent to a medication class.
 * @property int $patientid The patient that this medication was prescribed to.
 * @property string $patientnote Patient-facing note for this prescription. Labeled "note" in the UI.
 * @property string $pharmacy The name of the pharmacy where this medication was filled.
 * @property string $pharmacyncpdpid The NCPDP ID of the pharmacy for this medication..  See http://www.ncpdp.org/ for details.
 * @property string $prescribedby The user who prescribed this medication.
 * @property string $providernote Non-patient facing note for ths prescription. Labeled "internal note" in the UI.
 * @property int $refillsallowed The number of refills allowed when this medication was ordered.
 * @property string $route The route for the prescription.
 * @property string $rxnorm The list of RxNorm Identifiers that correspond to this medication. This list may contain both branded and generic identifiers. Note: Not All medications would include RX Norm.
 * @property string $source How this medication was entered. This can be the ordering provider, a medication history download (express scripts, medco, etc), ATHENA (which means it was entered manually), etc.
 * @property string $status The status of this medication. Medications in PEND status are associated with approved future orders and have not yet been submitted.
 * @property string $stopreason The reason why this medication was stopped.
 * @property string $therapeuticclass The therapeutic class for this medication. This is equivalent to a medication subclass.
 * @property string $unstructuredsig The unstructured sig for this medication, if any. If there is a structured sig, this will contain the formatted version of that sig.
 */
class MedicationApi extends BaseApiModel
{

    public $approvedby;
    public $billingndc;
    public $chartsharinggroupid;
    public $createdby;
    public $deletedby;
    public $earliestfilldate;
    public $encounterid;
    public $futuresubmitdate;
    public $issafetorenew;
    public $isstructuredsig;
    public $lastupdated;
    public $medication;
    public $medicationentryid;
    public $medicationid;
    public $ndcoptions;
    public $orderingmode;
    public $organclass;
    public $patientid;
    public $patientnote;
    public $pharmacy;
    public $pharmacyncpdpid;
    public $prescribedby;
    public $providernote;
    public $refillsallowed;
    public $route;
    public $rxnorm;
    public $source;
    public $status;
    public $stopreason;
    public $therapeuticclass;
    public $unstructuredsig;

    public function rules()
    {
        return [
            [['approvedby', 'billingndc', 'createdby', 'deletedby', 'earliestfilldate', 'futuresubmitdate', 'issafetorenew', 'isstructuredsig', 'lastupdated', 'medication', 'medicationentryid', 'ndcoptions', 'orderingmode', 'organclass', 'patientnote', 'pharmacy', 'pharmacyncpdpid', 'prescribedby', 'providernote', 'route', 'rxnorm', 'source', 'status', 'stopreason', 'therapeuticclass', 'unstructuredsig'], 'trim'],
            [['approvedby', 'billingndc', 'createdby', 'deletedby', 'earliestfilldate', 'futuresubmitdate', 'issafetorenew', 'isstructuredsig', 'lastupdated', 'medication', 'medicationentryid', 'ndcoptions', 'orderingmode', 'organclass', 'patientnote', 'pharmacy', 'pharmacyncpdpid', 'prescribedby', 'providernote', 'route', 'rxnorm', 'source', 'status', 'stopreason', 'therapeuticclass', 'unstructuredsig'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
