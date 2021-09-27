<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $acceptingnewpatientsyn Indicates whether the provider is accepting new patients. This field is currently only for informational purposes, and does not drive any athenaNet functionality.
 * @property string $ansinamecode This is the ANSI name with ANSI code for this provider's specialty.
 * @property string $ansispecialtycode This is the ANSI code for this provider's specialty.
 * @property string $billable Indicates if this is a billable provider.
 * @property string $createencounteroncheckinyn If true, appointments scheduled with this provider will create an encounter when the appointment is checked in for encounter supported appointment types. Only applies to the primary providerid. If the provider has other IDs with the same API, please use 'showallproviderids' to see which IDs create encounters.
 * @property string $createencounterprovideridlist A list of provider IDs for this provider NPI that will create an encounter when the appointment is checked in for encounter supported appointment types. Only populated if 'showallproviderids' is set.
 * @property string $displayname The preferred name to use when displaying this provider.
 * @property string $entitytype Either "Person" or "Non-Person" (e.g. X-Ray machines)
 * @property string $federalidnumber The federal ID number for provider, if SHOWFEDERALIDNUMBER is set.
 * @property string $firstname The provider's first name.
 * @property string $hideinportalyn If set, this provider does not appear in athenaCommunicator's web portal.
 * @property string $homedepartment For certain purposes, this can be considered to be the "home" or default department for a provider.
 * @property string $lastname The provider's last name.
 * @property int $npi The NPI for this provider, if available.
 * @property string $otherprovideridlist When showallproviderids is set to true, a list of all other athenaNet providers IDs that may refer to this same provider. If not present with showallproviderids, there are no other IDs other than the primary ID.
 * @property string $personalpronouns The preferred personal pronouns of this provider.
 * @property string $providergrouplist When showallproviderids is set to true, a list of all provider groups that this provider is registered in. Data is only relevant if a practice is using Provider-Group-Based Data Permissions in their practice.
 * @property int $providerid The ID to be used for this provider. Note that in athenaNet, an individual provider (as defined by a unique NPI) may have multiple provider IDs.  For the API, we have collapsed these to a single canonical ID.
 * @property string $providertype There is a long potential list of provider type in the form "full name (id)", but "MD", "NP" or "NP S" (Nurse Practitioner (Supervising)), "RES" (resident), "EQUIP", "DO", "PA" or "PASUP" (Physician's Assistant (Supervising)), "TECH", "RN", LPT", "CRNA" or "CRNASUP" (Certified Registered Nurse Anesthesiologist (Supervising)), and MA (Medical Assistant) are among the most common.
 * @property string $providertypeid This is just the ID (a text string) such as "NP" or "NP S" for the provider type.
 * @property string $providerusername The username of the provider.
 * @property string $scheduleresourcetype Name of the scheduling resource type tied to the provider.
 * @property string $schedulingname The scheduling name for this provider (as used in athenaNet).
 * @property string $sex The sex of this provider.
 * @property string $specialty A friendly name for this provider's specialty.
 * @property int $specialtyid The ID of the provider's specialty.
 * @property int $supervisingproviderid The ID of the supervising provider.
 * @property string $supervisingproviderusername The username of the supervising provider.
 * @property int $usualdepartmentid The "usual" department for this provider, if SHOWUSUALDEPARTMENTGUESSTHRESHOLD is set.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Provider extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%providers}}';
    }

    public function rules()
    {
        return [
            [['acceptingnewpatientsyn', 'ansinamecode', 'ansispecialtycode', 'billable', 'createencounteroncheckinyn', 'createencounterprovideridlist', 'displayname', 'entitytype', 'federalidnumber', 'firstname', 'hideinportalyn', 'homedepartment', 'lastname', 'otherprovideridlist', 'personalpronouns', 'providergrouplist', 'providertype', 'providertypeid', 'providerusername', 'scheduleresourcetype', 'schedulingname', 'sex', 'specialty', 'supervisingproviderusername'], 'trim'],
            [['acceptingnewpatientsyn', 'ansinamecode', 'ansispecialtycode', 'billable', 'createencounteroncheckinyn', 'createencounterprovideridlist', 'displayname', 'entitytype', 'federalidnumber', 'firstname', 'hideinportalyn', 'homedepartment', 'lastname', 'otherprovideridlist', 'personalpronouns', 'providergrouplist', 'providertype', 'providertypeid', 'providerusername', 'scheduleresourcetype', 'schedulingname', 'sex', 'specialty', 'supervisingproviderusername'], 'string'],
            [['npi', 'providerid', 'specialtyid', 'supervisingproviderid', 'usualdepartmentid', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($acceptingnewpatientsyn = ArrayHelper::getValue($apiObject, 'acceptingnewpatientsyn')) {
            $this->acceptingnewpatientsyn = $acceptingnewpatientsyn;
        }
        if($ansinamecode = ArrayHelper::getValue($apiObject, 'ansinamecode')) {
            $this->ansinamecode = $ansinamecode;
        }
        if($ansispecialtycode = ArrayHelper::getValue($apiObject, 'ansispecialtycode')) {
            $this->ansispecialtycode = $ansispecialtycode;
        }
        if($billable = ArrayHelper::getValue($apiObject, 'billable')) {
            $this->billable = $billable;
        }
        if($createencounteroncheckinyn = ArrayHelper::getValue($apiObject, 'createencounteroncheckinyn')) {
            $this->createencounteroncheckinyn = $createencounteroncheckinyn;
        }
        if($createencounterprovideridlist = ArrayHelper::getValue($apiObject, 'createencounterprovideridlist')) {
            $this->createencounterprovideridlist = $createencounterprovideridlist;
        }
        if($displayname = ArrayHelper::getValue($apiObject, 'displayname')) {
            $this->displayname = $displayname;
        }
        if($entitytype = ArrayHelper::getValue($apiObject, 'entitytype')) {
            $this->entitytype = $entitytype;
        }
        if($federalidnumber = ArrayHelper::getValue($apiObject, 'federalidnumber')) {
            $this->federalidnumber = $federalidnumber;
        }
        if($firstname = ArrayHelper::getValue($apiObject, 'firstname')) {
            $this->firstname = $firstname;
        }
        if($hideinportalyn = ArrayHelper::getValue($apiObject, 'hideinportalyn')) {
            $this->hideinportalyn = $hideinportalyn;
        }
        if($homedepartment = ArrayHelper::getValue($apiObject, 'homedepartment')) {
            $this->homedepartment = $homedepartment;
        }
        if($lastname = ArrayHelper::getValue($apiObject, 'lastname')) {
            $this->lastname = $lastname;
        }
        if($npi = ArrayHelper::getValue($apiObject, 'npi')) {
            $this->npi = $npi;
        }
        if($otherprovideridlist = ArrayHelper::getValue($apiObject, 'otherprovideridlist')) {
            $this->otherprovideridlist = $otherprovideridlist;
        }
        if($personalpronouns = ArrayHelper::getValue($apiObject, 'personalpronouns')) {
            $this->personalpronouns = $personalpronouns;
        }
        if($providergrouplist = ArrayHelper::getValue($apiObject, 'providergrouplist')) {
            $this->providergrouplist = $providergrouplist;
        }
        if($providerid = ArrayHelper::getValue($apiObject, 'providerid')) {
            $this->providerid = $providerid;
        }
        if($providerid = ArrayHelper::getValue($apiObject, 'providerid')) {
            $this->externalId = $providerid;
        }
        if($providertype = ArrayHelper::getValue($apiObject, 'providertype')) {
            $this->providertype = $providertype;
        }
        if($providertypeid = ArrayHelper::getValue($apiObject, 'providertypeid')) {
            $this->providertypeid = $providertypeid;
        }
        if($providerusername = ArrayHelper::getValue($apiObject, 'providerusername')) {
            $this->providerusername = $providerusername;
        }
        if($scheduleresourcetype = ArrayHelper::getValue($apiObject, 'scheduleresourcetype')) {
            $this->scheduleresourcetype = $scheduleresourcetype;
        }
        if($schedulingname = ArrayHelper::getValue($apiObject, 'schedulingname')) {
            $this->schedulingname = $schedulingname;
        }
        if($sex = ArrayHelper::getValue($apiObject, 'sex')) {
            $this->sex = $sex;
        }
        if($specialty = ArrayHelper::getValue($apiObject, 'specialty')) {
            $this->specialty = $specialty;
        }
        if($specialtyid = ArrayHelper::getValue($apiObject, 'specialtyid')) {
            $this->specialtyid = $specialtyid;
        }
        if($supervisingproviderid = ArrayHelper::getValue($apiObject, 'supervisingproviderid')) {
            $this->supervisingproviderid = $supervisingproviderid;
        }
        if($supervisingproviderusername = ArrayHelper::getValue($apiObject, 'supervisingproviderusername')) {
            $this->supervisingproviderusername = $supervisingproviderusername;
        }
        if($usualdepartmentid = ArrayHelper::getValue($apiObject, 'usualdepartmentid')) {
            $this->usualdepartmentid = $usualdepartmentid;
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

    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);

        return $saved;
    }
}
