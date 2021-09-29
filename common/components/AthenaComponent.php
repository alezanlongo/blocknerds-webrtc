<?php
namespace common\components;

use Yii;
use common\components\Athena\AthenaClient;
use common\components\Athena\models\Department;
use common\components\Athena\models\Patient;
use common\components\Athena\models\insurancePackages;
use common\components\Athena\models\insurance;
use common\components\Athena\models\Provider;
use common\components\Athena\models\PutAppointment200Response;

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
//var_dump(__METHOD__,$patientModelApi);die;
        $patient = Patient::find()
            ->where(['externalId' => $patientid])
            ->one();

        if (!$patient) {
            return Patient::createFromApiObject($patientModelApi);
        }

        return $patient->loadApiObject($patientModelApi);
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
            return PutAppointment200Response::createFromApiObject($appointmentModelApi);
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
}
