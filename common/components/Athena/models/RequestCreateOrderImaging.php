<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $diagnosissnomedcode The SNOMED code for diagnosis this order is for.
 * @property int $facilityid The athena ID of the imaging center you want to send the order to. Get a localized list using /chart/configuration/facilities.
 * @property string $facilitynote A note to send to the imaging center.
 * @property string $futuresubmitdate The date the order should be sent. Defaults to today.
 * @property bool $highpriority If true, then the order should be sent STAT.
 * @property int $ordertypeid The athena ID of the imaging study to order. Get the IDs using /reference/order/imaging.
 * @property string $providernote An internal note for the provider or staff.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestCreateOrderImaging extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_create_order_imagings}}';
    }

    public function rules()
    {
        return [
            [['facilitynote', 'futuresubmitdate', 'providernote'], 'trim'],
            [['diagnosissnomedcode', 'ordertypeid'], 'required'],
            [['facilitynote', 'futuresubmitdate', 'providernote'], 'string'],
            [['diagnosissnomedcode', 'facilityid', 'ordertypeid', 'externalId', 'id'], 'integer'],
            [['highpriority'], 'boolean'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($diagnosissnomedcode = ArrayHelper::getValue($apiObject, 'diagnosissnomedcode')) {
            $this->diagnosissnomedcode = $diagnosissnomedcode;
        }
        if($facilityid = ArrayHelper::getValue($apiObject, 'facilityid')) {
            $this->facilityid = $facilityid;
        }
        if($facilitynote = ArrayHelper::getValue($apiObject, 'facilitynote')) {
            $this->facilitynote = $facilitynote;
        }
        if($futuresubmitdate = ArrayHelper::getValue($apiObject, 'futuresubmitdate')) {
            $this->futuresubmitdate = $futuresubmitdate;
        }
        if($highpriority = ArrayHelper::getValue($apiObject, 'highpriority')) {
            $this->highpriority = $highpriority;
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
