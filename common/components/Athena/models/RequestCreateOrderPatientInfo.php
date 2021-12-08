<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $diagnosissnomedcode The SNOMED code for diagnosis this order is for.
 * @property string $externalnote An external note for the patient.
 * @property int $ordertypeid The athena ID of the patient information to order. Get the IDs using /reference/order/patientinfo.
 * @property string $providernote An internal note for the provider or staff.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestCreateOrderPatientInfo extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_create_order_patient_infos}}';
    }

    public function rules()
    {
        return [
            [['externalnote', 'providernote'], 'trim'],
            [['diagnosissnomedcode', 'ordertypeid'], 'required'],
            [['externalnote', 'providernote'], 'string'],
            [['diagnosissnomedcode', 'ordertypeid', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($diagnosissnomedcode = ArrayHelper::getValue($apiObject, 'diagnosissnomedcode')) {
            $this->diagnosissnomedcode = $diagnosissnomedcode;
        }
        if($externalnote = ArrayHelper::getValue($apiObject, 'externalnote')) {
            $this->externalnote = $externalnote;
        }
        if($ordertypeid = ArrayHelper::getValue($apiObject, 'ordertypeid')) {
            $this->ordertypeid = $ordertypeid;
        }
        if($providernote = ArrayHelper::getValue($apiObject, 'providernote')) {
            $this->providernote = $providernote;
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
