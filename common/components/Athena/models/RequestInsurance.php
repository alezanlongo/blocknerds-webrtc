<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $departmentid If set, we will use the department id in an attempt to add to the local patient.
 * @property string $expirationdate Set the date that the insurance will expire. This is usually a date within the next year and not in the past.
 * @property string $insuranceidnumber The insurance policy ID number (as presented on the insurance card itself).
 * @property int $insurancepackageid The athenaNet insurance package ID.
 * @property string $insurancephone The phone number for the insurance company. Note: This defaults to the insurance package phone number. If this is set, it will override it. Likewise if blanked out, it will go back to default.
 * @property string $insurancepolicyholder Name of the entity who holds this insurance policy. Required if entity type is set to non-person.
 * @property string $insurancepolicyholderaddress1 The first address line of the insurance policy holder.
 * @property string $insurancepolicyholderaddress2 The second address line of the insurance policy holder.
 * @property string $insurancepolicyholdercity The city of the insurance policy holder.
 * @property string $insurancepolicyholdercountrycode The country code (3 letter) of the insurance policy holder. Either this or insurancepolicyholdercountryiso3166 are acceptable.  Defaults to USA.
 * @property string $insurancepolicyholdercountryiso3166 The <a href="http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2">ISO 3166</a> country code of the insurance policy holder. Either this or insurancepolicyholdercountrycode are acceptable.  Defaults to US.
 * @property string $insurancepolicyholderdob The DOB of the insurance policy holder (mm/dd/yyyy).
 * @property string $insurancepolicyholderfirstname The first name of the insurance policy holder.  Except for self-pay, required for new policies.
 * @property string $insurancepolicyholderlastname The last name of the insurance policy holder.  Except for self-pay, required for new policies.
 * @property string $insurancepolicyholdermiddlename The middle name of the insurance policy holder.
 * @property string $insurancepolicyholdersex The sex of the insurance policy holder.  Except for self-pay, required for new policies.
 * @property string $insurancepolicyholderssn The SSN of the insurance policy holder.
 * @property string $insurancepolicyholderstate The state of the insurance policy holder.
 * @property string $insurancepolicyholdersuffix The suffix of the insurance policy holder.
 * @property string $insurancepolicyholderzip The zip of the insurance policy holder.
 * @property string $insuredentitytypeid
 * @property string $issuedate Set the date that the insurance was issued. This is usually a date in the past year and not in the future.
 * @property string $policynumber The insurance group number.  This is sometimes present on an insurance card.
 * @property int $relationshiptoinsuredid This patient's relationship to the policy holder (as an ID).  See <a href="/workflows/patient-relationship-mapping"> the mapping</a>. Please note that if this is set to 12, Entity Type must be set to 2.
 * @property int $sequencenumber 1 = primary, 2 = secondary.  Must have a primary before a secondary. This field is required if the insurance package is not a case policy.
 * @property bool $updateappointments If set to true, automatically updates all future appointments to use this insurance as primary or secondary, respective to the sequence number.
 * @property bool $validateinsuranceidnumber BETA FIELD: If true, this makes sure that you have entered a valid INSURANCEIDNUMBER.  If you didn't it will error. Setting this is probably a good thing and means you shouldn't have to do a ton of validation on the ID number.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestInsurance extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%request_insurances}}';
    }

    public function rules()
    {
        return [
            [['expirationdate', 'insuranceidnumber', 'insurancephone', 'insurancepolicyholder', 'insurancepolicyholderaddress1', 'insurancepolicyholderaddress2', 'insurancepolicyholdercity', 'insurancepolicyholdercountrycode', 'insurancepolicyholdercountryiso3166', 'insurancepolicyholderdob', 'insurancepolicyholderfirstname', 'insurancepolicyholderlastname', 'insurancepolicyholdermiddlename', 'insurancepolicyholdersex', 'insurancepolicyholderssn', 'insurancepolicyholderstate', 'insurancepolicyholdersuffix', 'insurancepolicyholderzip', 'insuredentitytypeid', 'issuedate', 'policynumber'], 'trim'],
            [['insurancepackageid'], 'required'],
            [['expirationdate', 'insuranceidnumber', 'insurancephone', 'insurancepolicyholder', 'insurancepolicyholderaddress1', 'insurancepolicyholderaddress2', 'insurancepolicyholdercity', 'insurancepolicyholdercountrycode', 'insurancepolicyholdercountryiso3166', 'insurancepolicyholderdob', 'insurancepolicyholderfirstname', 'insurancepolicyholderlastname', 'insurancepolicyholdermiddlename', 'insurancepolicyholdersex', 'insurancepolicyholderssn', 'insurancepolicyholderstate', 'insurancepolicyholdersuffix', 'insurancepolicyholderzip', 'insuredentitytypeid', 'issuedate', 'policynumber'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        $this->departmentid = ArrayHelper::getValue($apiObject, 'departmentid');
        $this->expirationdate = ArrayHelper::getValue($apiObject, 'expirationdate');
        $this->insuranceidnumber = ArrayHelper::getValue($apiObject, 'insuranceidnumber');
        $this->insurancepackageid = ArrayHelper::getValue($apiObject, 'insurancepackageid');
        $this->insurancephone = ArrayHelper::getValue($apiObject, 'insurancephone');
        $this->insurancepolicyholder = ArrayHelper::getValue($apiObject, 'insurancepolicyholder');
        $this->insurancepolicyholderaddress1 = ArrayHelper::getValue($apiObject, 'insurancepolicyholderaddress1');
        $this->insurancepolicyholderaddress2 = ArrayHelper::getValue($apiObject, 'insurancepolicyholderaddress2');
        $this->insurancepolicyholdercity = ArrayHelper::getValue($apiObject, 'insurancepolicyholdercity');
        $this->insurancepolicyholdercountrycode = ArrayHelper::getValue($apiObject, 'insurancepolicyholdercountrycode');
        $this->insurancepolicyholdercountryiso3166 = ArrayHelper::getValue($apiObject, 'insurancepolicyholdercountryiso3166');
        $this->insurancepolicyholderdob = ArrayHelper::getValue($apiObject, 'insurancepolicyholderdob');
        $this->insurancepolicyholderfirstname = ArrayHelper::getValue($apiObject, 'insurancepolicyholderfirstname');
        $this->insurancepolicyholderlastname = ArrayHelper::getValue($apiObject, 'insurancepolicyholderlastname');
        $this->insurancepolicyholdermiddlename = ArrayHelper::getValue($apiObject, 'insurancepolicyholdermiddlename');
        $this->insurancepolicyholdersex = ArrayHelper::getValue($apiObject, 'insurancepolicyholdersex');
        $this->insurancepolicyholderssn = ArrayHelper::getValue($apiObject, 'insurancepolicyholderssn');
        $this->insurancepolicyholderstate = ArrayHelper::getValue($apiObject, 'insurancepolicyholderstate');
        $this->insurancepolicyholdersuffix = ArrayHelper::getValue($apiObject, 'insurancepolicyholdersuffix');
        $this->insurancepolicyholderzip = ArrayHelper::getValue($apiObject, 'insurancepolicyholderzip');
        $this->insuredentitytypeid = ArrayHelper::getValue($apiObject, 'insuredentitytypeid');
        $this->issuedate = ArrayHelper::getValue($apiObject, 'issuedate');
        $this->policynumber = ArrayHelper::getValue($apiObject, 'policynumber');
        $this->relationshiptoinsuredid = ArrayHelper::getValue($apiObject, 'relationshiptoinsuredid');
        $this->sequencenumber = ArrayHelper::getValue($apiObject, 'sequencenumber');
        $this->updateappointments = ArrayHelper::getValue($apiObject, 'updateappointments');
        $this->validateinsuranceidnumber = ArrayHelper::getValue($apiObject, 'validateinsuranceidnumber');
        $this->id = ArrayHelper::getValue($apiObject, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
