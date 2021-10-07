<?php
namespace common\components;

use common\components\Athena\models\Checkin;
use spec\Prophecy\Doubler\Generator\Node\ReturnTypeNodeSpec;
use Yii;
use common\components\Athena\AthenaClient;
use common\components\Athena\models\Department;
use common\components\Athena\models\Encounter;
use common\components\Athena\models\Patient;
use common\components\Athena\models\PatientCase;
use common\components\Athena\models\PatientLocation;
use common\components\Athena\models\PatientStatus;
use common\components\Athena\models\Provider;
use common\components\Athena\models\PutAppointment200Response;
use common\components\Athena\models\insurance;
use common\components\Athena\models\insurancePackages;
use yii\base\Component;

class AthenaComponent extends Component
{
    private $client;
    protected  $practiceid;

    public function __construct(AthenaClient $client)
    {
        $this->client = $client;
    }

    public function setPracticeid(int $practiceid)
    {
        $this->practiceid = $practiceid;
    }

    public function getDepartments($flatten = false)
    {
    	$departmentsModelsApi = $this->client->getPracticeidDepartments($this->practiceid
        );

        $departmentsModels = [];

        foreach ($departmentsModelsApi as $departmentsModelApi) {
        	$departmentsModels[] =
        		Department::createFromApiObject(
        			$departmentsModelApi
        		);
        }

        if ($flatten) {
            return array_column($departmentsModels, 'name', 'departmentid');
        }

        return $departmentsModels;
    }

    public function getInsurancepackages($flatten = false)
    {
        $query = array(
            'insuranceplanname' => 'HDEPO National HRA',
            'memberid' => 'CD123456'
        );
        $insurancePackagesModelsApi = $this->client->getPracticeidInsurancepackages($this->practiceid, $query);

        $insurancePackagesModels = [];

        foreach ($insurancePackagesModelsApi as $insurancePackagesModelApi) {
            $insurancePackagesModels[] =
                insurancePackages::createFromApiObject(
                    $insurancePackagesModelApi
                );
        }

        if ($flatten) {
            return array_column($insurancePackagesModels, 'insuranceplanname', 'insurancepackageid');
        }

        return $insurancePackagesModels;
    }

    /**
     * @return Insurance
     */

    public function createInsurance($insuranceData, $patientId)
    {

        $insuranceData->sequencenumber = 1;
        $insuranceModelApi =
            $this->client->postPracticeidPatientsPatientidInsurances(
                $this->practiceid,
                $patientId,
                $insuranceData->toArray()
            );

        return $insuranceData->createFromApiObject($insuranceModelApi[0]);
    }

    /**
     * @return Patient
     */

    public function createPatient($patient)
    {
        $patientModelApi =
            $this->client->postPracticeidPatients(
                $this->practiceid,
                $patient->toArray()
            );
//var_dump(__METHOD__,$patientModelApi[0]->patientid);die;
        return $this->retrievePatient($patientModelApi[0]->patientid);
    }

    /**
     * @return Patient
     */
    public function retrievePatient($patientid)
    {
        $patientModelApi = $this->client->getPracticeidPatientsPatientid(
            $this->practiceid,
            $patientid
        )[0];

        $patient = Patient::find()
            ->where(['externalId' => $patientid])
            ->one();

        if (!$patient) {
            return Patient::createFromApiObject($patientModelApi);
        }

        return $patient->loadApiObject($patientModelApi);
    }


    /**
     * @return Checkin
     */
    public function startCheckin($appointmentid)
    {
        $startCheckinModelApi = $this->client->postPracticeidAppointmentsAppointmentidStartcheckin(
            $this->practiceid,
            $appointmentid,
        );

        return $startCheckinModelApi;
    }


    /**
     * @return Checkin
     */
    public function checkin($appointmentid)
    {
        $startCheckinModelApi = $this->client->postPracticeidAppointmentsAppointmentidCheckin(
            $this->practiceid,
            $appointmentid,
        );

        return $startCheckinModelApi;
    }


    /**
     * @return Checkin
     */
    public function cancelCheckin($appointmentid)
    {
        $startCheckinModelApi = $this->client->postPracticeidAppointmentsAppointmentidCancelcheckin(
            $this->practiceid,
            $appointmentid,
        );

        return $startCheckinModelApi;
    }


    public function getEcounters($patientid, $departmentid, $appointmentid = "",  $flatten = false)
    {
        $queryparams = [
            'departmentid'      => $departmentid,
            'showalltypes'      => "Y",
            'showallstatuses'   => "Y",
		    'encountertype'     => "INCLUDEALLSTATUSES",
        ];
        if($appointmentid !== ""){
            $queryparams['appointmentid'] = $appointmentid;
        }
        $encountersModelsApi = $this->client->getPracticeidChartPatientidEncounters(
            $this->practiceid,
            $patientid,
            $queryparams
        );

        $encountersModels = [];

        foreach ($encountersModelsApi as $encounterModelApi) {
            $encountersModels[] =
                Encounter::createFromApiObject(
                    $encounterModelApi
                );
        }

        return $encountersModels;
    }


    public function getPatientStatuses($flatten = false)
    {
        $patientStatusesModelsApi = $this->client->getPracticeidChartConfigurationPatientstatuses($this->practiceid);

        $patientStatusesModels = [];

        foreach ($patientStatusesModelsApi as $patientStatusModelApi) {
            $patientStatusesModels[] = PatientStatus::createFromApiObject($patientStatusModelApi);
        }

        if ($flatten) {
            return array_column($patientStatusesModels, 'patientstatusname', 'patientstatusid');
        }

        return $patientStatusesModels;
    }


    public function getPatientLocations($departmentId, $flatten = false)
    {
        $patientLocationsModelsApi = $this->client->getPracticeidChartConfigurationPatientlocations($this->practiceid, [
            'departmentId'  => $departmentId,
        ]);

        $patientLocationsModels = [];

        foreach ($patientLocationsModelsApi as $patientLocationModelApi) {
            $patientLocationsModels[] = PatientLocation::createFromApiObject($patientLocationModelApi);
        }

        if ($flatten) {
            return array_column($patientLocationsModels, 'name', 'patientlocationid');
        }

        return $patientLocationsModels;
    }


    /**
     * @return Encounter
     */
    public function createEncounter($encounterApiModel)
    {
        $encounterDB = Encounter::find()
            ->where(['externalId' => $encounterApiModel['externalId']])
            ->one();
        if (is_null($encounterDB)) {
            return Encounter::createFromApiObject($encounterApiModel);
        }else{
            $id = $encounterDB->id;
            $encounterDB->loadApiObject($encounterApiModel);
            $encounterDB->id = $id;

            return $encounterDB;
        }
    }


    /**
     * @return Encounter
     */
    public function updateEncounter(Encounter $encounter)
    {
        $putOrderModelApi = $this->client->putPracticeidChartEncounterEncounterid($this->practiceid, $encounter->encounterid, $encounter->toArray());
        if (!is_null($putOrderModelApi['errormessage'])) {
            return $encounter;
        }

        $id = $encounter->id;
        $encounterModelApi = $this->client->getPracticeidChartEncounterEncounterid($this->practiceid, $encounter->externalId);
        $encounterToUpdate = $encounter->loadApiObject($encounterModelApi[0]);
        $encounterToUpdate->id = $id;

        return $encounterToUpdate;

    }


    public function getProviders($flatten = false)
    {
        $providersModelsApi = $this->client->getPracticeidProviders($this->practiceid
        );

        $providersModels = [];

        foreach ($providersModelsApi as $providersModelApi) {
            $providersModels[] =
                Provider::createFromApiObject(
                    $providersModelApi
                );
        }

        if ($flatten) {
            return array_column($providersModels, 'displayname', 'externalId');
        }

        return $providersModels;
    }

    /**
     * @return Patient
     */

    public function createAppointment($appointment, $patientid)
    {
        $appointmentModelApi =
            $this->client->postPracticeidAppointmentsOpen(
                $this->practiceid,
                $appointment->toArray()
            );

        $appointmentids = array_flip($appointmentModelApi->appointmentids);

        $appointmentid = array_shift($appointmentids);

        // $this->bookAppointment(1195848, 34067);
        $this->bookAppointment($appointmentid, $patientid);

        return $this->retrieveAppointment($appointmentid);
    }

    /**
     * @return Appointment
     */
    public function retrieveAppointment($appointmentid)
    {
        $appointmentModelApi = $this->client->getPracticeidAppointmentsAppointmentid(
            $this->practiceid,
            $appointmentid
        );

        $appointment = PutAppointment200Response::find()
            ->where(['externalId' => $appointmentid])
            ->one();

        if (!$appointment) {
            return PutAppointment200Response::createFromApiObject($appointmentModelApi[0]);
        }

        return $appointment->loadApiObject($appointmentModelApi);
    }

    /**
     * @return Appointment
     */
    public function bookAppointment($appointmentid, $patientid)
    {
        $bookedAppointmentModelApi = $this->client->putPracticeidAppointmentsAppointmentid(
            $this->practiceid,
            $appointmentid,
            [
                'patientid' => $patientid,
                'ignoreschedulablepermission' => "true",
                'appointmenttypeid' => 62
            ]
        );
    }

    /**
     * @return Patient
     */

    public function createPatientCase($patientCase, $patientid)
    {
        $patientCaseModelApi =
            $this->client->postPracticeidPatientsPatientidDocumentsPatientcase(
                $this->practiceid,
                $patientid,
                $patientCase->toArray()
            );

        return $this->retrievePatientCase(
            $patientid,
            $patientCaseModelApi->patientcaseid
        );
    }

    /**
     * @return PatientCase
     */
    public function retrievePatientCase($patientid, $patientcaseid)
    {
        $patientCaseModelApi = $this->client->getPracticeidPatientsPatientidDocumentsPatientcasePatientcaseid(
            $patientcaseid,
            $this->practiceid,
            $patientid
        )[0];

        $patientCase = PatientCase::find()
            ->where(['externalId' => $patientcaseid])
            ->one();

        if (!$patientCase) {
            return PatientCase::createFromApiObject($patientCaseModelApi);
        }

        return $patientCase->loadApiObject($patientCaseModelApi);
    }
}
