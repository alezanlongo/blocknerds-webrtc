<?php

namespace common\components;

use Yii;
use common\components\Athena\AthenaClient;
use common\components\Athena\models\Department;
use common\components\Athena\models\Patient;
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
}
