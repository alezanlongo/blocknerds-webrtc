<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $additionalinstructions Sig field. Additional modifiers for when to take the medication.
 * @property string $administernote An additional note to the provider or staff for administration.
 * @property int $diagnosissnomedcode The SNOMED code for diagnosis this order is for.
 * @property bool $dispenseaswritten Whether the prescription should be marked as dispense as written (i.e., no substitutions without consulting the doctor).
 * @property int $dosagequantity Sig field. The numerical amount of medication to take.
 * @property string $dosagequantityunit Sig field. The unit of the dosage quantity, and required if that is passed in. Get the list of available values from /reference/order/prescription/dosagequantityunits. Most values are not valid for each individual medication.
 * @property float $duration Sig field. The numerical amount of days to take this medication for.
 * @property string $externalnote An additional note to the patient.
 * @property int $facilityid The athena ID of the pharmacy you want to send the prescription to. Defaults to the patient default pharmacy. You can use this or the pharmacy NCPDP ID but not both. Get a localized list using /chart/configuration/facilities.
 * @property string $frequency Sig field. How often to take doses of the medication. Get the list of available values from /reference/order/prescription/frequencies.
 * @property string $ndc The NDC of the medication to order. You may use this instead of ordertypeid
 * @property int $numrefillsallowed The number of refills allowed for this prescription. Defaults to 0.
 * @property string $orderingmode Selects whether you wish to prescribe, administer, or dispense this medication.
 * @property int $ordertypeid The athena ID of the medication to order. Must be an orderable medication. We currently do not support adding of compound or unlisted medicaitons. Get the IDs using /reference/order/prescription. You may use this, an NDC, or a RxNormID.
 * @property string $pharmacyncpdpid The NCPDP ID of the pharmacy you want to send the prescription to. You can use this instead of the facilityid, but not both.
 * @property string $pharmacynote A note to send to the pharmacy.
 * @property string $providernote An internal note for the provider or staff.
 * @property string $rxnormid The RxNormID of the medication to order. You may use this instead of ordertypeid. If the RxNormID maps to more than one possible orderable medication, it will be rejected.
 * @property int $totalquantity The total amount of medication to be prescribed. It should match the total amount needed as described in the sig.
 * @property string $totalquantityunit The unit of the total quantity, and required if that is passed in. Get the list of available values from /reference/order/prescription/totalquantityunits. Most values are not valid for each individual medication.
 * @property string $unstructuredsig The unstructured sig. If this field is set please leave all other sig fields blank.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestCreateOrderPrescription extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_create_order_prescriptions}}';
    }

    public function rules()
    {
        return [
            [['additionalinstructions', 'administernote', 'dosagequantityunit', 'externalnote', 'frequency', 'ndc', 'orderingmode', 'pharmacyncpdpid', 'pharmacynote', 'providernote', 'rxnormid', 'totalquantityunit', 'unstructuredsig'], 'trim'],
            [['diagnosissnomedcode'], 'required'],
            [['additionalinstructions', 'administernote', 'dosagequantityunit', 'externalnote', 'frequency', 'ndc', 'orderingmode', 'pharmacyncpdpid', 'pharmacynote', 'providernote', 'rxnormid', 'totalquantityunit', 'unstructuredsig'], 'string'],
            [['diagnosissnomedcode', 'dosagequantity', 'facilityid', 'numrefillsallowed', 'ordertypeid', 'totalquantity', 'externalId', 'id'], 'integer'],
            [['dispenseaswritten'], 'boolean'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($additionalinstructions = ArrayHelper::getValue($apiObject, 'additionalinstructions')) {
            $this->additionalinstructions = $additionalinstructions;
        }
        if($administernote = ArrayHelper::getValue($apiObject, 'administernote')) {
            $this->administernote = $administernote;
        }
        if($diagnosissnomedcode = ArrayHelper::getValue($apiObject, 'diagnosissnomedcode')) {
            $this->diagnosissnomedcode = $diagnosissnomedcode;
        }
        if($dispenseaswritten = ArrayHelper::getValue($apiObject, 'dispenseaswritten')) {
            $this->dispenseaswritten = $dispenseaswritten;
        }
        if($dosagequantity = ArrayHelper::getValue($apiObject, 'dosagequantity')) {
            $this->dosagequantity = $dosagequantity;
        }
        if($dosagequantityunit = ArrayHelper::getValue($apiObject, 'dosagequantityunit')) {
            $this->dosagequantityunit = $dosagequantityunit;
        }
        if($duration = ArrayHelper::getValue($apiObject, 'duration')) {
            $this->duration = $duration;
        }
        if($externalnote = ArrayHelper::getValue($apiObject, 'externalnote')) {
            $this->externalnote = $externalnote;
        }
        if($facilityid = ArrayHelper::getValue($apiObject, 'facilityid')) {
            $this->facilityid = $facilityid;
        }
        if($frequency = ArrayHelper::getValue($apiObject, 'frequency')) {
            $this->frequency = $frequency;
        }
        if($ndc = ArrayHelper::getValue($apiObject, 'ndc')) {
            $this->ndc = $ndc;
        }
        if($numrefillsallowed = ArrayHelper::getValue($apiObject, 'numrefillsallowed')) {
            $this->numrefillsallowed = $numrefillsallowed;
        }
        if($orderingmode = ArrayHelper::getValue($apiObject, 'orderingmode')) {
            $this->orderingmode = $orderingmode;
        }
        if($ordertypeid = ArrayHelper::getValue($apiObject, 'ordertypeid')) {
            $this->ordertypeid = $ordertypeid;
        }
        if($pharmacyncpdpid = ArrayHelper::getValue($apiObject, 'pharmacyncpdpid')) {
            $this->pharmacyncpdpid = $pharmacyncpdpid;
        }
        if($pharmacynote = ArrayHelper::getValue($apiObject, 'pharmacynote')) {
            $this->pharmacynote = $pharmacynote;
        }
        if($providernote = ArrayHelper::getValue($apiObject, 'providernote')) {
            $this->providernote = $providernote;
        }
        if($rxnormid = ArrayHelper::getValue($apiObject, 'rxnormid')) {
            $this->rxnormid = $rxnormid;
        }
        if($totalquantity = ArrayHelper::getValue($apiObject, 'totalquantity')) {
            $this->totalquantity = $totalquantity;
        }
        if($totalquantityunit = ArrayHelper::getValue($apiObject, 'totalquantityunit')) {
            $this->totalquantityunit = $totalquantityunit;
        }
        if($unstructuredsig = ArrayHelper::getValue($apiObject, 'unstructuredsig')) {
            $this->unstructuredsig = $unstructuredsig;
        }
        if($externalId = ArrayHelper::getValue($apiObject, 'externalId')) {
            $this->externalId = $externalId;
        }
        if($id = ArrayHelper::getValue($apiObject, 'id')) {
            $this->id = $id;
        }

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
    /* FIXME link doesn't work
    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);

        return $saved;
    }
    */
}
