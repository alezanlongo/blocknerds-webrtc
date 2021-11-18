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
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['{patientid}'])) ? $dataResponse['data']['{patientid}'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\PatientApi($value));
            }
            return $dataApiModel;
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
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['insurances'])) ? $dataResponse['data']['insurances'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\insurancePackagesApi($value));
            }
            return $dataApiModel;
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
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['providers'])) ? $dataResponse['data']['providers'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\ProviderApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return AppointmentResponse
     */
    public function postPracticeidAppointmentsOpen($practiceid, array $body = [])
    {
        $path = '/v1/{practiceid}/appointments/open';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\AppointmentResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param appointmentid
     * @return Checkin
     */
    public function postPracticeidAppointmentsAppointmentidCheckin($practiceid, $appointmentid, array $body = [])
    {
        $path = '/v1/{practiceid}/appointments/{appointmentid}/checkin';
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
     * @param appointmentid
     * @return Checkin
     */
    public function postPracticeidAppointmentsAppointmentidCancelcheckin($practiceid, $appointmentid, array $body = [])
    {
        $path = '/v1/{practiceid}/appointments/{appointmentid}/cancelcheckin';
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
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['{encounterid}'])) ? $dataResponse['data']['{encounterid}'] : $dataResponse['data'];
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
    public function getPracticeidAppointmentsAppointmentid($practiceid, $appointmentid, array $query = [])
    {
        $path = '/v1/{practiceid}/appointments/{appointmentid}';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{appointmentid}', $appointmentid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
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
            return new \common\components\Athena\apiModels\PutAppointment200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @return PatientCase
     */
    public function getPracticeidPatientsPatientidDocumentsPatientcase($practiceid, $patientid, array $query = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/documents/patientcase';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['patientcases'])) ? $dataResponse['data']['patientcases'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\PatientCaseApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @return PostPatientCase200Response
     */
    public function postPracticeidPatientsPatientidDocumentsPatientcase($practiceid, $patientid, array $body = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/documents/patientcase';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PostPatientCase200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param patientcaseid
     * @param practiceid
     * @param patientid
     * @return PatientCase
     */
    public function getPracticeidPatientsPatientidDocumentsPatientcasePatientcaseid($patientcaseid, $practiceid, $patientid, array $query = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/documents/patientcase/{patientcaseid}';
        $path = str_replace('{patientcaseid}', $patientcaseid, $path);
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['{patientcaseid}'])) ? $dataResponse['data']['{patientcaseid}'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\PatientCaseApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param patientcaseid
     * @param practiceid
     * @param patientid
     * @return PostPatientCase200Response
     */
    public function putPracticeidPatientsPatientidDocumentsPatientcasePatientcaseid($patientcaseid, $practiceid, $patientid, array $body = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/documents/patientcase/{patientcaseid}';
        $path = str_replace('{patientcaseid}', $patientcaseid, $path);
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'put' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PostPatientCase200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription
     */
    public function getPracticeidPatientsChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/patients/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscriptionApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function postPracticeidPatientsChangedSubscription($practiceid, array $body = [])
    {
        $path = '/v1/{practiceid}/patients/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function deletePracticeidPatientsChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/patients/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'delete' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return PatientChanged
     */
    public function getPracticeidPatientsChanged($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/patients/changed';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PatientChangedApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return AppointmentChanged
     */
    public function getPracticeidAppointmentsChanged($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/appointments/changed';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\AppointmentChangedApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription
     */
    public function getPracticeidAppointmentsChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/appointments/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscriptionApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function postPracticeidAppointmentsChangedSubscription($practiceid, array $body = [])
    {
        $path = '/v1/{practiceid}/appointments/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function deletePracticeidAppointmentsChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/appointments/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'delete' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription
     */
    public function getPracticeidDocumentsPatientcaseChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/documents/patientcase/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscriptionApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function postPracticeidDocumentsPatientcaseChangedSubscription($practiceid, array $body = [])
    {
        $path = '/v1/{practiceid}/documents/patientcase/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function deletePracticeidDocumentsPatientcaseChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/documents/patientcase/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'delete' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return PatientCaseChanged
     */
    public function getPracticeidDocumentsPatientcaseChanged($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/documents/patientcase/changed';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PatientCaseChangedApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param patientcaseid
     * @param practiceid
     * @return ActionNote
     */
    public function getPracticeidDocumentsPatientcasePatientcaseidActions($patientcaseid, $practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/documents/patientcase/{patientcaseid}/actions';
        $path = str_replace('{patientcaseid}', $patientcaseid, $path);
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['actionnotes'])) ? $dataResponse['data']['actionnotes'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\ActionNoteApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param patientcaseid
     * @param practiceid
     * @return PostActionNote200Response
     */
    public function postPracticeidDocumentsPatientcasePatientcaseidActions($patientcaseid, $practiceid, array $body = [])
    {
        $path = '/v1/{practiceid}/documents/patientcase/{patientcaseid}/actions';
        $path = str_replace('{patientcaseid}', $patientcaseid, $path);
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PostActionNote200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param patientcaseid
     * @param practiceid
     * @param patientid
     * @return PutReassignPatient200Response
     */
    public function putPracticeidPatientsPatientidDocumentsPatientcasePatientcaseidAssign($patientcaseid, $practiceid, $patientid, array $body = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/documents/patientcase/{patientcaseid}/assign';
        $path = str_replace('{patientcaseid}', $patientcaseid, $path);
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'put' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PutReassignPatient200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param patientcaseid
     * @param practiceid
     * @param patientid
     * @return PutClosePatient200Response
     */
    public function putPracticeidPatientsPatientidDocumentsPatientcasePatientcaseidClose($patientcaseid, $practiceid, $patientid, array $body = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/documents/patientcase/{patientcaseid}/close';
        $path = str_replace('{patientcaseid}', $patientcaseid, $path);
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'put' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PutClosePatient200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return CloseReason
     */
    public function getPracticeidReferenceDocumentsPatientcaseClosereasons($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/reference/documents/patientcase/closereasons';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['closereasons'])) ? $dataResponse['data']['closereasons'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\CloseReasonApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @return ChartAlert
     */
    public function getPracticeidPatientsPatientidChartalert($practiceid, $patientid, array $query = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/chartalert';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChartAlertApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @return PostChartAlert200Response
     */
    public function postPracticeidPatientsPatientidChartalert($practiceid, $patientid, array $body = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/chartalert';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PostChartAlert200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription
     */
    public function getPracticeidChartHealthhistoryMedicationChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/medication/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscriptionApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function postPracticeidChartHealthhistoryMedicationChangedSubscription($practiceid, array $body = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/medication/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function deletePracticeidChartHealthhistoryMedicationChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/medication/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'delete' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return MedicationChanged
     */
    public function getPracticeidChartHealthhistoryMedicationChanged($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/medication/changed';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\MedicationChangedApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription
     */
    public function getPracticeidChartHealthhistoryProblemsChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/problems/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscriptionApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function postPracticeidChartHealthhistoryProblemsChangedSubscription($practiceid, array $body = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/problems/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function deletePracticeidChartHealthhistoryProblemsChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/problems/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'delete' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ProblemChanged
     */
    public function getPracticeidChartHealthhistoryProblemsChanged($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/problems/changed';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ProblemChangedApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @return ClinicalDocument
     */
    public function getPracticeidPatientsPatientidDocumentsClinicaldocument($practiceid, $patientid, array $query = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/documents/clinicaldocument';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['clinicaldocument'])) ? $dataResponse['data']['clinicaldocument'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\ClinicalDocumentApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @return ClinicalDocument200Response
     */
    public function postPracticeidPatientsPatientidDocumentsClinicaldocument($practiceid, $patientid, array $body = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/documents/clinicaldocument';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ClinicalDocument200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @param clinicaldocumentid
     * @return ClinicalDocument
     */
    public function getPracticeidPatientsPatientidDocumentsClinicaldocumentClinicaldocumentid($practiceid, $patientid, $clinicaldocumentid, array $query = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/documents/clinicaldocument/{clinicaldocumentid}';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);
        $path = str_replace('{clinicaldocumentid}', $clinicaldocumentid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['{clinicaldocumentid}'])) ? $dataResponse['data']['{clinicaldocumentid}'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\ClinicalDocumentApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @param clinicaldocumentid
     * @return ClinicalDocument200Response
     */
    public function putPracticeidPatientsPatientidDocumentsClinicaldocumentClinicaldocumentid($practiceid, $patientid, $clinicaldocumentid, array $body = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/documents/clinicaldocument/{clinicaldocumentid}';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);
        $path = str_replace('{clinicaldocumentid}', $clinicaldocumentid, $path);

        $dataResponse = $this->callMethod($path, 'put' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ClinicalDocument200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @param clinicaldocumentid
     * @return ClinicalDocument200Response
     */
    public function deletePracticeidPatientsPatientidDocumentsClinicaldocumentClinicaldocumentid($practiceid, $patientid, $clinicaldocumentid, array $query = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/documents/clinicaldocument/{clinicaldocumentid}';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);
        $path = str_replace('{clinicaldocumentid}', $clinicaldocumentid, $path);

        $dataResponse = $this->callMethod($path, 'delete' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ClinicalDocument200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param pageid
     * @param patientid
     * @param clinicaldocumentid
     * @return ClinicalDocumentPage
     */
    public function getPracticeidPatientsPatientidDocumentsClinicaldocumentClinicaldocumentidPagesPageid($practiceid, $pageid, $patientid, $clinicaldocumentid, array $query = [])
    {
        $path = '/v1/{practiceid}/patients/{patientid}/documents/clinicaldocument/{clinicaldocumentid}/pages/{pageid}';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{pageid}', $pageid, $path);
        $path = str_replace('{patientid}', $patientid, $path);
        $path = str_replace('{clinicaldocumentid}', $clinicaldocumentid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ClinicalDocumentPageApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription
     */
    public function getPracticeidChartHealthhistoryAllergiesChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/allergies/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscriptionApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function postPracticeidChartHealthhistoryAllergiesChangedSubscription($practiceid, array $body = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/allergies/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function deletePracticeidChartHealthhistoryAllergiesChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/allergies/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'delete' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return AllergyChanged
     */
    public function getPracticeidChartHealthhistoryAllergiesChanged($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/allergies/changed';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\AllergyChangedApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param encounterid
     * @return Vitals
     */
    public function getPracticeidChartEncounterEncounteridVitals($practiceid, $encounterid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/encounter/{encounterid}/vitals';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{encounterid}', $encounterid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['vitals'])) ? $dataResponse['data']['vitals'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\VitalsCustomApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param encounterid
     * @return VitalsResponse
     */
    public function postPracticeidChartEncounterEncounteridVitals($practiceid, $encounterid, array $body = [])
    {
        $path = '/v1/{practiceid}/chart/encounter/{encounterid}/vitals';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{encounterid}', $encounterid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\VitalsResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param encounterid
     * @param vitalid
     * @return PutVitalsResponse
     */
    public function putPracticeidChartEncounterEncounteridVitalsVitalid($practiceid, $encounterid, $vitalid, array $body = [])
    {
        $path = '/v1/{practiceid}/chart/encounter/{encounterid}/vitals/{vitalid}';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{encounterid}', $encounterid, $path);
        $path = str_replace('{vitalid}', $vitalid, $path);

        $dataResponse = $this->callMethod($path, 'put' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PutVitalsResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return VitalsConfiguration
     */
    public function getPracticeidChartConfigurationVitals($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/configuration/vitals';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['vitals'])) ? $dataResponse['data']['vitals'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\VitalsConfigurationApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription
     */
    public function getPracticeidChartHealthhistoryVaccineChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/vaccine/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscriptionApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function postPracticeidChartHealthhistoryVaccineChangedSubscription($practiceid, array $body = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/vaccine/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function deletePracticeidChartHealthhistoryVaccineChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/vaccine/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'delete' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return VaccineChanged
     */
    public function getPracticeidChartHealthhistoryVaccineChanged($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/vaccine/changed';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\VaccineChangedApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription
     */
    public function getPracticeidChartHealthhistoryFamilyhistoryChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/familyhistory/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscriptionApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function postPracticeidChartHealthhistoryFamilyhistoryChangedSubscription($practiceid, array $body = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/familyhistory/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return ChangedSubscription200Response
     */
    public function deletePracticeidChartHealthhistoryFamilyhistoryChangedSubscription($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/familyhistory/changed/subscription';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'delete' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ChangedSubscription200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return FamilyHistoryChanged
     */
    public function getPracticeidChartHealthhistoryFamilyhistoryChanged($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/healthhistory/familyhistory/changed';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\FamilyHistoryChangedApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @return GetProblem200Response
     */
    public function getPracticeidChartPatientidProblems($practiceid, $patientid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/{patientid}/problems';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\GetProblem200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @return PostProblem200Response
     */
    public function postPracticeidChartPatientidProblems($practiceid, $patientid, array $body = [])
    {
        $path = '/v1/{practiceid}/chart/{patientid}/problems';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PostProblem200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @param problemid
     * @return PostProblem200Response
     */
    public function putPracticeidChartPatientidProblemsProblemid($practiceid, $patientid, $problemid, array $body = [])
    {
        $path = '/v1/{practiceid}/chart/{patientid}/problems/{problemid}';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);
        $path = str_replace('{problemid}', $problemid, $path);

        $dataResponse = $this->callMethod($path, 'put' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PostProblem200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @return ListMedications
     */
    public function getPracticeidChartPatientidMedications($practiceid, $patientid, array $query = [])
    {
        $path = '/v1/{practiceid}/chart/{patientid}/medications';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\ListMedicationsApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param patientid
     * @return PostMedication200Response
     */
    public function postPracticeidChartPatientidMedications($practiceid, $patientid, array $body = [])
    {
        $path = '/v1/{practiceid}/chart/{patientid}/medications';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PostMedication200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @return MedicationReference
     */
    public function getPracticeidReferenceMedications($practiceid, array $query = [])
    {
        $path = '/v1/{practiceid}/reference/medications';
        $path = str_replace('{practiceid}', $practiceid, $path);

        $dataResponse = $this->callMethod($path, 'get' , $query);
        if($dataResponse['success']){
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['medications'])) ? $dataResponse['data']['medications'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Athena\apiModels\MedicationReferenceApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @param practiceid
     * @param medicationentryid
     * @param patientid
     * @return PutMedication200Response
     */
    public function putPracticeidChartPatientidMedicationsMedicationentryid($practiceid, $medicationentryid, $patientid, array $body = [])
    {
        $path = '/v1/{practiceid}/chart/{patientid}/medications/{medicationentryid}';
        $path = str_replace('{practiceid}', $practiceid, $path);
        $path = str_replace('{medicationentryid}', $medicationentryid, $path);
        $path = str_replace('{patientid}', $patientid, $path);

        $dataResponse = $this->callMethod($path, 'put' , $body);
        if($dataResponse['success']){
            return new \common\components\Athena\apiModels\PutMedication200ResponseApi($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
}
