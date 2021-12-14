<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $departmentid The ID of the department where the privacy information was verified.
 * @property string $expirationdate The date this approval expires (for release of billing information and assignment of benefits).
 * @property bool $insuredsignature If set, this flag sets the Assignment of Benefits privacy checkbox.
 * @property bool $patientsignature If set, this flag sets the Release of Billing Information privacy checkbox.
 * @property bool $privacynotice If set, this flag sets the Privacy Notice privacy checkbox.
 * @property string $reasonpatientunabletosign If the patient is unable to sign a reason why.
 * @property string $signaturedatetime If presenting an e-signature, the mm/dd/yyyy hh24:mi:ss formatted time that the signer signed. This is required if a signature name is provided.
 * @property string $signaturename If presenting an e-siganture, the name the signer typed, up to 100 characters.
 * @property string $signerrelationshiptopatientid If presenting an e-signature, and the signer is signing on behalf of someone else, the relationship of the patient to the signer. There is a documentation page with details.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PostPrivacyInformationVerified extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%post_privacy_information_verifieds}}';
    }

    public function rules()
    {
        return [
            [['expirationdate', 'reasonpatientunabletosign', 'signaturedatetime', 'signaturename', 'signerrelationshiptopatientid'], 'trim'],
            [['departmentid', 'signaturedatetime', 'signaturename'], 'required'],
            [['expirationdate', 'reasonpatientunabletosign', 'signaturedatetime', 'signaturename', 'signerrelationshiptopatientid'], 'string'],
            [['departmentid', 'externalId', 'id'], 'integer'],
            [['insuredsignature', 'patientsignature', 'privacynotice'], 'boolean'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($expirationdate = ArrayHelper::getValue($apiObject, 'expirationdate')) {
            $this->expirationdate = $expirationdate;
        }
        if($insuredsignature = ArrayHelper::getValue($apiObject, 'insuredsignature')) {
            $this->insuredsignature = $insuredsignature;
        }
        if($patientsignature = ArrayHelper::getValue($apiObject, 'patientsignature')) {
            $this->patientsignature = $patientsignature;
        }
        if($privacynotice = ArrayHelper::getValue($apiObject, 'privacynotice')) {
            $this->privacynotice = $privacynotice;
        }
        if($reasonpatientunabletosign = ArrayHelper::getValue($apiObject, 'reasonpatientunabletosign')) {
            $this->reasonpatientunabletosign = $reasonpatientunabletosign;
        }
        if($signaturedatetime = ArrayHelper::getValue($apiObject, 'signaturedatetime')) {
            $this->signaturedatetime = $signaturedatetime;
        }
        if($signaturename = ArrayHelper::getValue($apiObject, 'signaturename')) {
            $this->signaturename = $signaturename;
        }
        if($signerrelationshiptopatientid = ArrayHelper::getValue($apiObject, 'signerrelationshiptopatientid')) {
            $this->signerrelationshiptopatientid = $signerrelationshiptopatientid;
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
