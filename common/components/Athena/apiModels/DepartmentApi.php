<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $address The address for this department.
 * @property string $address2 The address (line 2) for this department.
 * @property string $chartsharinggroupid The chart sharing group ID puts departments (that are enabled for Clinicals) into groups with regards to clinical information. Any chart related GET calls with department IDs that are in the same chart sharing group generally return the same set of information. For example, if department IDs 1 and 2 are in chart sharing group 1000 and department IDs 20 and 21 are in chart sharing group 2000, the allergies endpoint for department ID 1 or 2 will return the same set of data, and using department IDs 20 and 21 may return a different set of allergies. Most commonly, this is used to ensure mental health and other sensitive charts remain separate from other data.
 * @property string $city The city for this department.
 * @property string $clinicalproviderfax This is the department's fax number for receiving orders.
 * @property string $clinicals Is Clinicals turned on for this department. Possible values are "ON", "OFF", "DOCUMENTSONLY" (which means that they accept documents, but generally not doing encounters in Clinicals) or "ADMINONLY" which for most purposes is the same as "OFF", though means that it is in the middle of implementation.
 * @property string $communicatorbrandid The ID of the patient-facing brand this department belongs to.
 * @property string $creditcardtypes An array of credit card types accepted in this department (for retail transactions). If not present, credit cards can not be processed for this department for retail transactions.
 * @property string $departmentid The department ID.  This ID is local to each practice.
 * @property string $doesnotobservedst Set to true if this practice does not observe daylight savings time.
 * @property string $ecommercecreditcardtypes An array of credit card types accepted in this department (for ecommerce transactions). If not present, credit cards can not be processed for this department for ecommerce transactions.
 * @property string $fax This is the department's fax number.  Sometimes this is not configured even though the department can receive faxes.  This happens when the main clinical provider has their fax number set up but the department does not.  You should check both this field and the "clinicalproviderfax" field when determining if faxes are possible.
 * @property string $ishospitaldepartment Flag denoting if this department is a hospital department.
 * @property string $latitude The latitude may be set by the practice to correct any bad public mapping data.  In degrees, with a decimal component.
 * @property string $longitude The longitude may be set by the practice to correct any bad public mapping data.  In degrees, with a decimal component.
 * @property string $medicationhistoryconsent Should medication history consent be asked in this practice. This is a practice-wide setting at the end of the day; if it is on for one Clinicals department (of status "ON"), it will be on for all Clinicals departments.
 * @property string $name The department's name.
 * @property string $oneyearcontractmax For a year long payment contract, the practice's suggested maximum amount for this department.
 * @property string $patientdepartmentname The patient-friendly name for this department, if set by the practice.
 * @property string $phone This number is not always patient-facing; it may be a "back line".
 * @property string $placeofservicefacility Is this department a "facility" or not
 * @property string $placeofservicetypeid An athena-internal ID for the type of service location (e.g. office vs. hospital)
 * @property string $placeofservicetypename The name describing the type of service location (e.g. office vs. hospital)
 * @property string $portalurl The URL for the practice or the portal, if available, for this department.  This may be the practice's website where they have a link to the portal.
 * @property string $providergroupid The ID of the financial group this department belongs to.  Not all practices have distinct financial groups.
 * @property string $providergroupname The name of the financial group this department belongs to.  Not all practices have distinct financial groups.
 * @property string $providerlist If providerlist is passed in (set to true), a list of provider IDs
 * @property string $servicedepartment Indicates if this is a department where billable services are performed (i.e. a department where you can create claims).
 * @property string $singleappointmentcontractmax For a single appointment payment contract, the practice's suggested maximum amount for this department.
 * @property string $state The state for this department.
 * @property string $timezone The timezone for this department, offset from UTC/GMT.
 * @property string $timezonename  Timezone name of the department.
 * @property string $timezoneoffset The "normal" timezone offset from UTC/GMT.  The "timezone" combines this and "doesnotobservedst".  During daylight savings, this is 1 less than "timezone".
 * @property string $zip The zip code for this department.
 */
class DepartmentApi extends BaseApiModel
{

    public $address;
    public $address2;
    public $chartsharinggroupid;
    public $city;
    public $clinicalproviderfax;
    public $clinicals;
    public $communicatorbrandid;
    public $creditcardtypes;
    public $departmentid;
    public $doesnotobservedst;
    public $ecommercecreditcardtypes;
    public $fax;
    public $ishospitaldepartment;
    public $latitude;
    public $longitude;
    public $medicationhistoryconsent;
    public $name;
    public $oneyearcontractmax;
    public $patientdepartmentname;
    public $phone;
    public $placeofservicefacility;
    public $placeofservicetypeid;
    public $placeofservicetypename;
    public $portalurl;
    public $providergroupid;
    public $providergroupname;
    public $providerlist;
    public $servicedepartment;
    public $singleappointmentcontractmax;
    public $state;
    public $timezone;
    public $timezonename;
    public $timezoneoffset;
    public $zip;

    public function rules()
    {
        return [
            [['address', 'address2', 'chartsharinggroupid', 'city', 'clinicalproviderfax', 'clinicals', 'communicatorbrandid', 'creditcardtypes', 'departmentid', 'doesnotobservedst', 'ecommercecreditcardtypes', 'fax', 'ishospitaldepartment', 'latitude', 'longitude', 'medicationhistoryconsent', 'name', 'oneyearcontractmax', 'patientdepartmentname', 'phone', 'placeofservicefacility', 'placeofservicetypeid', 'placeofservicetypename', 'portalurl', 'providergroupid', 'providergroupname', 'providerlist', 'servicedepartment', 'singleappointmentcontractmax', 'state', 'timezone', 'timezonename', 'timezoneoffset', 'zip'], 'trim'],
            [['address', 'address2', 'chartsharinggroupid', 'city', 'clinicalproviderfax', 'clinicals', 'communicatorbrandid', 'creditcardtypes', 'departmentid', 'doesnotobservedst', 'ecommercecreditcardtypes', 'fax', 'ishospitaldepartment', 'latitude', 'longitude', 'medicationhistoryconsent', 'name', 'oneyearcontractmax', 'patientdepartmentname', 'phone', 'placeofservicefacility', 'placeofservicetypeid', 'placeofservicetypename', 'portalurl', 'providergroupid', 'providergroupname', 'providerlist', 'servicedepartment', 'singleappointmentcontractmax', 'state', 'timezone', 'timezonename', 'timezoneoffset', 'zip'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
