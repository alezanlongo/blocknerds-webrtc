<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $diagnosissnomedcode The SNOMED code for diagnosis this order is for.
 * @property int $facilityid The athena ID of the facility you want to send the order to. Get a localized list using /chart/configuration/facilities.
 * @property string $facilitynote A note to send to the facility.
 * @property string $futuresubmitdate The date the order should be sent. Defaults to today.
 * @property bool $highpriority If true, then the order should be sent STAT.
 * @property string $notetopatient If this referral has a field for 'Notes to Patient' you may fill it in with this parameter.  If the referral does not have this field available, this will error.
 * @property int $ordertypeid The athena ID of the referral type.
 * @property string $procedurecode If this referral has a field for 'Procedure Code' you may fill it in with this parameter.  If the referral does not have this field available, this will error.
 * @property string $providernote An internal note for the provider or staff.
 * @property string $reasonforreferral If this referral has a field for 'Reason for Referral' you may fill it in with this parameter.  If the referral does not have this field available, this will error.
 * @property string $startdate If this referral has a field for 'Start Date' you may fill it in with this parameter.  If the referral does not have this field available, this will error.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestCreateOrderReferral extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_create_order_referrals}}';
    }

    public function rules()
    {
        return [
            [['facilitynote', 'futuresubmitdate', 'notetopatient', 'procedurecode', 'providernote', 'reasonforreferral', 'startdate'], 'trim'],
            [['diagnosissnomedcode', 'ordertypeid'], 'required'],
            [['facilitynote', 'futuresubmitdate', 'notetopatient', 'procedurecode', 'providernote', 'reasonforreferral', 'startdate'], 'string'],
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
        if($notetopatient = ArrayHelper::getValue($apiObject, 'notetopatient')) {
            $this->notetopatient = $notetopatient;
        }
        if($ordertypeid = ArrayHelper::getValue($apiObject, 'ordertypeid')) {
            $this->ordertypeid = $ordertypeid;
        }
        if($procedurecode = ArrayHelper::getValue($apiObject, 'procedurecode')) {
            $this->procedurecode = $procedurecode;
        }
        if($providernote = ArrayHelper::getValue($apiObject, 'providernote')) {
            $this->providernote = $providernote;
        }
        if($reasonforreferral = ArrayHelper::getValue($apiObject, 'reasonforreferral')) {
            $this->reasonforreferral = $reasonforreferral;
        }
        if($startdate = ArrayHelper::getValue($apiObject, 'startdate')) {
            $this->startdate = $startdate;
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
