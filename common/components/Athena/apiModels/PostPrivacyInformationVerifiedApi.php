<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $departmentid The ID of the department where the privacy information was verified.
 * @property string $expirationdate The date this approval expires (for release of billing information and assignment of benefits).
 * @property bool $insuredsignature If set, this flag sets the Assignment of Benefits privacy checkbox.
 * @property bool $patientsignature If set, this flag sets the Release of Billing Information privacy checkbox.
 * @property bool $privacynotice If set, this flag sets the Privacy Notice privacy checkbox.
 * @property string $reasonpatientunabletosign If the patient is unable to sign a reason why.
 * @property string $signaturedatetime If presenting an e-signature, the mm/dd/yyyy hh24:mi:ss formatted time that the signer signed. This is required if a signature name is provided.
 * @property string $signaturename If presenting an e-siganture, the name the signer typed, up to 100 characters.
 * @property string $signerrelationshiptopatientid If presenting an e-signature, and the signer is signing on behalf of someone else, the relationship of the patient to the signer. There is a documentation page with details.
 */
class PostPrivacyInformationVerifiedApi extends BaseApiModel
{

    public $departmentid;
    public $expirationdate;
    public $insuredsignature;
    public $patientsignature;
    public $privacynotice;
    public $reasonpatientunabletosign;
    public $signaturedatetime;
    public $signaturename;
    public $signerrelationshiptopatientid;

    public function rules()
    {
        return [
            [['expirationdate', 'reasonpatientunabletosign', 'signaturedatetime', 'signaturename', 'signerrelationshiptopatientid'], 'trim'],
            [['departmentid', 'signaturedatetime', 'signaturename'], 'required'],
            [['expirationdate', 'reasonpatientunabletosign', 'signaturedatetime', 'signaturename', 'signerrelationshiptopatientid'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
