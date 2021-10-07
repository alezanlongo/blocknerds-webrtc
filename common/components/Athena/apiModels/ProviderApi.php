<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
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
 */
class ProviderApi extends BaseApiModel
{

    public $acceptingnewpatientsyn;
    public $ansinamecode;
    public $ansispecialtycode;
    public $billable;
    public $createencounteroncheckinyn;
    public $createencounterprovideridlist;
    public $displayname;
    public $entitytype;
    public $federalidnumber;
    public $firstname;
    public $hideinportalyn;
    public $homedepartment;
    public $lastname;
    public $npi;
    public $otherprovideridlist;
    public $personalpronouns;
    public $providergrouplist;
    public $providerid;
    public $providertype;
    public $providertypeid;
    public $providerusername;
    public $scheduleresourcetype;
    public $schedulingname;
    public $sex;
    public $specialty;
    public $specialtyid;
    public $supervisingproviderid;
    public $supervisingproviderusername;
    public $usualdepartmentid;

    public function rules()
    {
        return [
            [['acceptingnewpatientsyn', 'ansinamecode', 'ansispecialtycode', 'billable', 'createencounteroncheckinyn', 'createencounterprovideridlist', 'displayname', 'entitytype', 'federalidnumber', 'firstname', 'hideinportalyn', 'homedepartment', 'lastname', 'otherprovideridlist', 'personalpronouns', 'providergrouplist', 'providertype', 'providertypeid', 'providerusername', 'scheduleresourcetype', 'schedulingname', 'sex', 'specialty', 'supervisingproviderusername'], 'trim'],
            [['acceptingnewpatientsyn', 'ansinamecode', 'ansispecialtycode', 'billable', 'createencounteroncheckinyn', 'createencounterprovideridlist', 'displayname', 'entitytype', 'federalidnumber', 'firstname', 'hideinportalyn', 'homedepartment', 'lastname', 'otherprovideridlist', 'personalpronouns', 'providergrouplist', 'providertype', 'providertypeid', 'providerusername', 'scheduleresourcetype', 'schedulingname', 'sex', 'specialty', 'supervisingproviderusername'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
