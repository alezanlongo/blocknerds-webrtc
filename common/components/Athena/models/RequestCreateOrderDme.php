<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestCreateOrderDme extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_create_order_dmes}}';
    }

    public function rules()
    {
        return [
            [['facilityid', 'facilitynote', 'orderingmode', 'providernote', 'unstructuredsig'], 'trim'],
            [['diagnosissnomedcode', 'ordertypeid'], 'required'],
            [['facilityid', 'facilitynote', 'orderingmode', 'providernote', 'unstructuredsig'], 'string'],
            [['diagnosissnomedcode', 'numrefillsallowed', 'ordertypeid', 'externalId', 'id'], 'integer'],
            [['dispenseaswritten'], 'boolean'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($diagnosissnomedcode = ArrayHelper::getValue($apiObject, 'diagnosissnomedcode')) {
            $this->diagnosissnomedcode = $diagnosissnomedcode;
        }
        if($dispenseaswritten = ArrayHelper::getValue($apiObject, 'dispenseaswritten')) {
            $this->dispenseaswritten = $dispenseaswritten;
        }
        if($facilityid = ArrayHelper::getValue($apiObject, 'facilityid')) {
            $this->facilityid = $facilityid;
        }
        if($facilitynote = ArrayHelper::getValue($apiObject, 'facilitynote')) {
            $this->facilitynote = $facilitynote;
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
        if($providernote = ArrayHelper::getValue($apiObject, 'providernote')) {
            $this->providernote = $providernote;
        }
        if($totalquantity = ArrayHelper::getValue($apiObject, 'totalquantity')) {
            $this->totalquantity = $totalquantity;
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
