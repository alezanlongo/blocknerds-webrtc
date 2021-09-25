<?php

namespace common\components\Athena;

use Yii;
use yii\base\Model;


class AthenaClient extends \common\components\Athena\AthenaOauth
{
    /**
     * @param practiceid
     * @return PostPatient200Response
     */
    public function postPracticeidPatients($practiceid, array $body = [])
    {
        $path = '/v1/{practiceid}/patients';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['patients'])) ? $dataResponse['data']['patients'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\PostPatient200ResponseApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @return Patient
     */
    public function getPracticeidPatientsPatientid($practiceid, $patientid, array $query = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PatientApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return Department
     */
    public function getPracticeidDepartments($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/departments';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['departments'])) ? $dataResponse['data']['departments'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\DepartmentApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @return Insurance
     */
    public function postPracticeidPatientsPatientidInsurances($practiceid, $patientid, array $body = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/insurances';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['insurances'])) ? $dataResponse['data']['insurances'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\InsuranceApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return insurancePackages
     */
    public function getPracticeidInsurancepackages($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/insurancepackages';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\insurancePackagesApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return Provider
     */
    public function getPracticeidProviders($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/providers';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ProviderApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return Appointments
     */
    public function postPracticeidAppointmentsOpen($practiceid, array $body = [])
    {
        $path = '/v1/{practiceid}/appointments/open';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['open'])) ? $dataResponse['data']['open'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\AppointmentsApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param appointmentid
     * @return Checkin
     */
    public function postPracticeidAppointmentsAppointmentidStartcheckin($practiceid, $appointmentid, array $body = [])
    {
        $path = '/v1/{practiceid}/appointments/{appointmentid}/startcheckin';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{appointmentid}', $appointmentid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\CheckinApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @return Encounter
     */
    public function getPracticeidChartPatientidEncounters($practiceid, $patientid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/{patientid}/encounters';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['encounters'])) ? $dataResponse['data']['encounters'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\EncounterApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param encounterid
     * @return Encounter
     */
    public function getPracticeidChartEncounterEncounterid($practiceid, $encounterid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/encounter/{encounterid}';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{encounterid}', $encounterid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\EncounterApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param encounterid
     * @return PutEncounter200Response
     */
    public function putPracticeidChartEncounterEncounterid($practiceid, $encounterid, array $body = [])
    {
        $path = '/v1/{practiceid}/chart/encounter/{encounterid}';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{encounterid}', $encounterid, $path);

        $dataResponse = $this->callMethod($path, 'put' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PutEncounter200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return PatientLocation
     */
    public function getPracticeidChartConfigurationPatientlocations($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/configuration/patientlocations';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['patientlocations'])) ? $dataResponse['data']['patientlocations'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\PatientLocationApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return PatientStatus
     */
    public function getPracticeidChartConfigurationPatientstatuses($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/configuration/patientstatuses';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['patientstatuses'])) ? $dataResponse['data']['patientstatuses'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\PatientStatusApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param appointmentid
     * @return PutAppointment200Response
     */
    public function putPracticeidAppointmentsAppointmentid($practiceid, $appointmentid, array $body = [])
    {
        $path = '/v1/{practiceid}/appointments/{appointmentid}';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{appointmentid}', $appointmentid, $path);

        $dataResponse = $this->callMethod($path, 'put' , $body);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['{appointmentid}'])) ? $dataResponse['data']['{appointmentid}'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\PutAppointment200ResponseApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
}
