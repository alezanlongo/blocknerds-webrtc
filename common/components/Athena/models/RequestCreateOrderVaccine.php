<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestCreateOrderVaccine extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_create_order_vaccines}}';
    }

    public function rules()
    {
        return [
            [['administernote', 'declineddate', 'facilityid', 'ndc', 'orderingmode', 'performondate', 'pharmacynote', 'providernote', 'totalquantityunit', 'unstructuredsig'], 'trim'],
            [['diagnosissnomedcode', 'ordertypeid'], 'required'],
            [['administernote', 'declineddate', 'facilityid', 'ndc', 'orderingmode', 'performondate', 'pharmacynote', 'providernote', 'totalquantityunit', 'unstructuredsig'], 'string'],
            [['declinedreason', 'diagnosissnomedcode', 'numrefillsallowed', 'ordertypeid', 'externalId', 'id'], 'integer'],
            [['dispenseaswritten'], 'boolean'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($administernote = ArrayHelper::getValue($apiObject, 'administernote')) {
            $this->administernote = $administernote;
        }
        if($declineddate = ArrayHelper::getValue($apiObject, 'declineddate')) {
            $this->declineddate = $declineddate;
        }
        if($declinedreason = ArrayHelper::getValue($apiObject, 'declinedreason')) {
            $this->declinedreason = $declinedreason;
        }
        if($diagnosissnomedcode = ArrayHelper::getValue($apiObject, 'diagnosissnomedcode')) {
            $this->diagnosissnomedcode = $diagnosissnomedcode;
        }
        if($dispenseaswritten = ArrayHelper::getValue($apiObject, 'dispenseaswritten')) {
            $this->dispenseaswritten = $dispenseaswritten;
        }
        if($facilityid = ArrayHelper::getValue($apiObject, 'facilityid')) {
            $this->facilityid = $facilityid;
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
        if($performondate = ArrayHelper::getValue($apiObject, 'performondate')) {
            $this->performondate = $performondate;
        }
        if($pharmacynote = ArrayHelper::getValue($apiObject, 'pharmacynote')) {
            $this->pharmacynote = $pharmacynote;
        }
        if($providernote = ArrayHelper::getValue($apiObject, 'providernote')) {
            $this->providernote = $providernote;
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
