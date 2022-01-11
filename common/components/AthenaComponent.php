<?php
namespace common\components;

use Yii;
use Yii\helpers\ArrayHelper;
use common\components\Athena\AthenaClient;
use common\components\Athena\apiModels\AppointmentApi;
use common\components\Athena\apiModels\AppointmentNoteApi;
use common\components\Athena\apiModels\EncounterApi;
use common\components\Athena\apiModels\FamilyHistoryApi;
use common\components\Athena\apiModels\LabResultApi;
use common\components\Athena\apiModels\MedicationApi;
use common\components\Athena\apiModels\PatientApi;
use common\components\Athena\apiModels\PatientCaseApi;
use common\components\Athena\apiModels\ProblemApi;
use common\components\Athena\apiModels\VaccineApi;
use common\components\Athena\models\ActionNote;
use common\components\Athena\models\AdminDocument;
use common\components\Athena\models\AdminDocumentPageDetail;
use common\components\Athena\models\Appointment;
use common\components\Athena\models\AppointmentNote;
use common\components\Athena\models\ChartAlert;
use common\components\Athena\models\Checkin;
use common\components\Athena\models\ClinicalDocument;
use common\components\Athena\models\ClinicalDocumentPageDetail;
use common\components\Athena\models\CloseReason;
use common\components\Athena\models\Department;
use common\components\Athena\models\Diagnoses;
use common\components\Athena\models\Encounter;
use common\components\Athena\models\EncounterVitals;
use common\components\Athena\models\Event;
use common\components\Athena\models\EventDiagnose;
use common\components\Athena\models\FamilyHistory;
use common\components\Athena\models\InsuranceCardImage;
use common\components\Athena\models\LabResult;
use common\components\Athena\models\Medication;
use common\components\Athena\models\MedicationReference;
use common\components\Athena\models\Order;
use common\components\Athena\models\OrderableDme;
use common\components\Athena\models\OrderableImaging;
use common\components\Athena\models\OrderableLab;
use common\components\Athena\models\OrderableMedication;
use common\components\Athena\models\OrderableVaccine;
use common\components\Athena\models\OtherOrderType;
use common\components\Athena\models\Patient;
use common\components\Athena\models\PatientCase;
use common\components\Athena\models\PatientInfoHandout;
use common\components\Athena\models\PatientInsurance;
use common\components\Athena\models\PatientLocation;
use common\components\Athena\models\PatientStatus;
use common\components\Athena\models\Problem;
use common\components\Athena\models\Provider;
use common\components\Athena\models\PutAppointment200Response;
use common\components\Athena\models\Readings;
use common\components\Athena\models\ReferralOrderType;
use common\components\Athena\models\TopInsurancePackages;
use common\components\Athena\models\Vaccine;
use common\components\Athena\models\Vitals;
use common\components\Athena\models\VitalsConfiguration;
use common\components\Athena\models\MedicalHistory;
use common\components\Athena\models\MedicalHistoryQuestion;
use common\components\Athena\models\MedicalHistoryConfiguration;
use common\components\Athena\models\MedicalHistoryConfigurationQuestion;
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

    public function getPracticeid()
    {
        return $this->practiceid;
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

    public function getInsuranceTopPackages()
    {

        $topInsurancePackagesModelsApi = $this->client->getPracticeidMiscTopinsurancepackages($this->practiceid);

        $topInsurancePackagesModels = [];

        foreach ($topInsurancePackagesModelsApi as $topInsurancePackagesModelApi) {
            $topInsurancePackagesModels[] =
                TopInsurancePackages::createFromApiObject(
                    $topInsurancePackagesModelApi
                );
        }

        return array_column($topInsurancePackagesModels, 'name', 'insurancepackageid');
    }


    public function getpatientInsurances($patientId, $departmentid)
    {

        $patientInsuranceModelsApi = $this->client->getPracticeidPatientsPatientidInsurances(
            $this->practiceid,
            $patientId,
            [
                'departmentid'  => $departmentid
            ]
        );

        $patientInsuranceModels = [];

        foreach ($patientInsuranceModelsApi as $patientInsuranceModelApi) {
            $patientInsuranceModels[] =
                PatientInsurance::createFromApiObject(
                    $patientInsuranceModelApi
                );
        }

        return $patientInsuranceModels;
    }

    /**
     * @return Insurance
     */
    public function createInsurance($patientId, $new = false, $insuranceData = [])
    {
        if($new){
            $insuranceData['insurancepackageid'] = 0;
            $insuranceData['sequencenumber'] = 1;
            $insuranceModelApi = $this->client->postPracticeidPatientsPatientidInsurances(
                $this->practiceid,
                $patientId,
                $insuranceData
            );
            $insuranceData = new PatientInsurance;
            $insuranceData->createFromApiObject($insuranceModelApi[0]);
        }else{
            $insuranceData->sequencenumber = 1;
            $insuranceModelApi = $this->client->postPracticeidPatientsPatientidInsurances(
                $this->practiceid,
                $patientId,
                $insuranceData->toArray()
            );
        }

        return $insuranceData->createFromApiObject($insuranceModelApi[0]);
    }

    /**
     * @return Insurance
     */
    public function updateInsurance($insurance, $insuranceId, $patientId)
    {
        $putInsuranceApi = $this->client->putPracticeidPatientsPatientidInsurancesInsuranceid($this->practiceid, $patientId, $insuranceId, $insurance);

        if (!empty($putInsuranceApi['errormessage'])) {
            return $insurance;
        }

    }

    public function deleteInsurance($insuranceId, $patientId){
        $deleteInsurance = $this->client->deletePracticeidPatientsPatientidInsurancesInsuranceid($this->practiceid, $patientId, $insuranceId);

        return $deleteInsurance;
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

        return $this->retrievePatient($patientModelApi[0]->patientid);
    }

    /**
     * @return Update patient
     */
    public function updatePatient($patient, $patientId)
    {
        $putPatientApi = $this->client->putPracticeidPatientsPatientid($this->practiceid, $patientId, $patient);

        if (!empty($putPatientApi['errormessage'])) {
            return $patient;
        }

    }

    /**
     * @return Patient
     */
    public function retrievePatient($patientId)
    {
        $patientModelApi = $this->client->getPracticeidPatientsPatientid(
            $this->practiceid,
            $patientId
        )[0];

        return $this->obtainPatient($patientId, $patientModelApi);
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
        //echo "<pre>";
        foreach ($providersModelsApi as $providersModelApi) {
            $arrAux = (array)$providersModelApi;
            //var_dump($arrAux['createencounterprovideridlist']); echo " => "; var_dump($arrAux['displayname']); echo "<br>";
            if (array_key_exists('createencounterprovideridlist', $arrAux)) {
                $providersModels[] =
                    Provider::createFromApiObject(
                        $providersModelApi
                    );
            }
        }
        //exit();

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

        return $this->obtainPatientCase($patientcaseid, $patientCaseModelApi);
    }

    public function retrievePatientSubscriptionStatus()
    {
        $subscriptionStatusApi = $this->client->getPracticeidPatientsChangedSubscription($this->practiceid);

        return $subscriptionStatusApi;
    }

    public function patientsSubscription($event)
    {
        $subscriptionStatusApi = $this->client->postPracticeidPatientsChangedSubscription($this->practiceid,
            [
                'eventname' => $event,
            ]
        );

        return $subscriptionStatusApi;
    }

    public function patientChanges(): array
    {
        $changedPatients = $this->client->getPracticeidPatientsChanged($this->practiceid);
        $changedPatientResult = [];
        try {
            foreach( $changedPatients->patients as $patientApi ) {
                $patientModel = $this->obtainPatient($patientApi->patientid, $patientApi);
                $changedPatientResult[] = [$patientModel->id, $patientModel->externalId, $patientModel->save()];
            }
        } catch(\Exception $e) {
            throw $e;//TODO handle this
        }

        return $changedPatientResult;
    }

    public function retrieveAppointmentSubscriptionStatus()
    {
        $subscriptionStatusApi = $this->client->getPracticeidAppointmentsChangedSubscription($this->practiceid);

        return $subscriptionStatusApi;
    }

    public function appointmentsSubscription($event)
    {
        $subscriptionStatusApi = $this->client->postPracticeidAppointmentsChangedSubscription($this->practiceid,
            [
                'eventname'                     => $event,
                'includeremindercall'           => TRUE,
                'includesuggestedoverbooking'   => TRUE
            ]
        );

        return $subscriptionStatusApi;
    }

    public function appointmentChanges(): array
    {
        $changedAppointmentss = $this->client->getPracticeidAppointmentsChanged($this->practiceid);
        $changedAppointmentResult = [];
        try {
            foreach( $changedAppointmentss->appointments as $appointmentApi ) {
                $appointmentModel = $this->obtainAppointment($appointmentApi->appointmentid, $appointmentApi);
                $row = [
                    $appointmentModel->id,
                    $appointmentModel->externalId,
                    $appointmentModel->save(),
                ];
                if(property_exists($appointmentApi, 'encounterid')){
                    if(!is_null($appointmentApi->encounterid)){
                        $encounterModelApi = $this->client->getPracticeidChartEncounterEncounterid($this->practiceid, $appointmentApi->encounterid);
                        $encounterModel = $this->obtainEncounter($appointmentApi->encounterid, $encounterModelApi[0]);

                        array_push($row, $encounterModel->id);
                        array_push($row, $encounterModel->externalId);
                        array_push($row, $encounterModel->save());
                    }
                }
                $changedAppointmentResult[] = $row;
            }
        } catch(\Exception $e) {
            throw $e;//TODO handle this
        }

        return $changedAppointmentResult;
    }

    public function retrievePatientCaseSubscriptionStatus()
    {
        $subscriptionStatusApi = $this->client->getPracticeidDocumentsPatientcaseChangedSubscription($this->practiceid);

        return $subscriptionStatusApi;
    }

    public function patientsCaseSubscription($event)
    {
        $subscriptionStatusApi = $this->client->postPracticeidDocumentsPatientcaseChangedSubscription($this->practiceid,
            [
                'eventname' => $event,
            ]
        );

        return $subscriptionStatusApi;
    }

    public function patientCasesChanges(): array
    {
        $changedPatientCases = $this->client->getPracticeidDocumentsPatientcaseChanged($this->practiceid);
        $changedPatientCasesResult = [];
        try {
            foreach( $changedPatientCases->patientcases as $patientCaseApi ) {
                $patientCaseModel = $this->obtainPatientCase($patientCaseApi->patientid, $patientCaseApi);
                $changedPatientCasesResult[] = [$patientCaseModel->id, $patientCaseModel->externalId, $patientCaseModel->save()];
            }
        } catch(\Exception $e) {
            throw $e;//TODO handle this
        }

        return $changedPatientCasesResult;
    }

    public function getProvidersUsernames($flatten = false)
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
            return array_column($providersModels, 'providerusername', 'providerusername');
        }

        return $providersModels;
    }

    public function reassignPatientCase($patientCase, $reassignPatientCase)
    {
        $reassignedPatientCaseModelApi =
            $this->client->putPracticeidPatientsPatientidDocumentsPatientcasePatientcaseidAssign(
                $patientCase->externalId,
                $this->practiceid,
                $patientCase->patientid,
                $reassignPatientCase->toArray()
            );

        return $this->retrievePatientCase($patientCase->patientid, $patientCase->externalId);
    }

    public function getCloseReasons($patientCaseId, $flatten = false)
    {
        $closeReasonsModelsApi = $this->client->getPracticeidReferenceDocumentsPatientcaseClosereasons($this->practiceid,
            ['patientcaseid' => $patientCaseId]
        );

        $closeReasonsModels = [];

        foreach ($closeReasonsModelsApi  as $closeReasonsModelApi ) {
            $closeReasonsModels[] =
                CloseReason::createFromApiObject(
                    $closeReasonsModelApi
                );
        }

        if ($flatten) {
            return array_column($closeReasonsModels, 'reason', 'reasonid');
        }

        return $closeReasonsModels;
    }

    public function closePatientCase($patientCase, $closePatientCase)
    {
        $closedPatientCaseModelApi =
            $this->client->putPracticeidPatientsPatientidDocumentsPatientcasePatientcaseidClose(
                $patientCase->externalId,
                $this->practiceid,
                $patientCase->patientid,
                $closePatientCase->toArray()
            );

        return $this->retrievePatientCase($patientCase->patientid, $patientCase->externalId);
    }

    /**
     * @return Patient
     */

    public function updatePatientCase($patientCase, $updatePatientCase)
    {
        $patientCaseModelApi =
            $this->client->putPracticeidPatientsPatientidDocumentsPatientcasePatientcaseid(
                $patientCase->externalId,
                $this->practiceid,
                $patientCase->patientid,
                $updatePatientCase->toArray()
            );

        return $this->retrievePatientCase(
            $patientCase->patientid,
            $patientCaseModelApi->patientcaseid
        );
    }


    /**
     * @return Patient
     */

    public function addActionNote($patientCase, $actionNote)
    {
        $actionNoteModelApi =
            $this->client->postPracticeidDocumentsPatientcasePatientcaseidActions(
                $patientCase->externalId,
                $this->practiceid,
                $actionNote->toArray()
            );

        return $this->retrieveLastCreatedActionNote(
            $patientCase->externalId
        );
    }

    public function retrieveLastCreatedActionNote($patientCaseId)
    {
        $actionNotesModelsApi = $this->client->getPracticeidDocumentsPatientcasePatientcaseidActions(
            $patientCaseId,
            $this->practiceid
        );

        return ActionNote::createFromApiObject(
            end($actionNotesModelsApi)
        );
    }


    public function createChartAlert($patient, $chartAlert)
    {
        $chartAlertModelApi =
            $this->client->postPracticeidPatientsPatientidChartalert(
                $this->practiceid,
                $patient->externalId,
                $chartAlert->toArray()
            );
    }

    public function retrieveChartAlert($patient)
    {
        $chartAlertModelApi = $this->client->getPracticeidPatientsPatientidChartalert(
            $this->practiceid,
            $patient->externalId,
            ['departmentid' => $patient->departmentid]
        );

        return ChartAlert::createFromApiObject(
            $chartAlertModelApi
        );
    }

    public function retrieveMedicationSubscriptionStatus()
    {
        $subscriptionStatusApi = $this->client->getPracticeidChartHealthhistoryMedicationChangedSubscription($this->practiceid);

        return $subscriptionStatusApi;
    }

    public function medicationsSubscription($event)
    {
        $subscriptionStatusApi = $this->client->postPracticeidChartHealthhistoryMedicationChangedSubscription($this->practiceid,
            [
                'eventname' => $event,
            ]
        );

        return $subscriptionStatusApi;
    }

    public function medicationChanges(): array
    {
        $changedMedications = $this->client->getPracticeidChartHealthhistoryMedicationChanged($this->practiceid);

        $changedMedicationsResult = [];
        try {
            foreach( $changedMedications->medications as $medicationApi ) {
                $medicationModel = $this->obtainMedication($medicationApi->medicationentryid, $medicationApi);
                $changedMedicationsResult[] = [$medicationModel->id, $medicationModel->externalId, $medicationModel->save()];
            }
        } catch(\Exception $e) {
            throw $e;//TODO handle this
        }

        return $changedMedicationsResult;
    }

    public function retrieveProblemSubscriptionStatus()
    {
        $subscriptionStatusApi = $this->client->getPracticeidChartHealthhistoryProblemsChangedSubscription($this->practiceid);

        return $subscriptionStatusApi;
    }

    public function problemsSubscription($event)
    {
        $subscriptionStatusApi = $this->client->postPracticeidChartHealthhistoryProblemsChangedSubscription($this->practiceid,
            [
                'eventname' => $event,
            ]
        );

        return $subscriptionStatusApi;
    }

    public function problemChanges(): array
    {
        $changedProblems = $this->client->getPracticeidChartHealthhistoryProblemsChanged($this->practiceid);
        $changedProblemResult = [];
        try {
            foreach( $changedProblems->problems as $problemApi ) {
                $problemModel = $this->obtainProblem($problemApi->problemid, $problemApi);
                $changedProblemResult[] = [$problemModel->id, $problemModel->externalId, $problemModel->save()];
            }
        } catch(\Exception $e) {
            throw $e;//TODO handle this
        }

        return $changedProblemResult;
    }

    public function getClinicalDocuments($patientId, $flatten = false)
    {
        $clinicalDocumentsModelsApi = $this->client->getPracticeidPatientsPatientidDocumentsClinicaldocument($this->practiceid, $patientId);

        $clinicalDocumentsModels = [];

        foreach ($clinicalDocumentsModelsApi as $clinicalDocumentModelApi) {
            $clinicalDocumentsModels[] = ClinicalDocument::createFromApiObject($clinicalDocumentModelApi);
        }

        return $clinicalDocumentsModels;
    }


    public function createClinicalDocument($patientId, $postClinicalDocument)
    {
        $postClinicalDocumentsModelsApi = $this->client->postPracticeidPatientsPatientidDocumentsClinicaldocument(
            $this->practiceid,
            $patientId,
            $postClinicalDocument->toArray()
        );

        if($postClinicalDocumentsModelsApi->success){
            $clinicalDocumentsModelsApi = $this->client->getPracticeidPatientsPatientidDocumentsClinicaldocumentClinicaldocumentid(
                $this->practiceid,
                $patientId,
                $postClinicalDocumentsModelsApi->clinicaldocumentid
            );
            $clinicalDocument = ClinicalDocument::createFromApiObject($clinicalDocumentsModelsApi[0]);
            $clinicalDocument->patientid = $patientId;
            $clinicalDocument->save();
            foreach ($clinicalDocumentsModelsApi[0]['pages'] as $key => $value){
                $pageDetail = ClinicalDocumentPageDetail::createFromApiObject($value);
                $pageDetail->link("clinicalDocument", $clinicalDocument);
                $pageDetail->save();
            }

            return $clinicalDocument;
        }

        return $postClinicalDocument;
    }


    public function getClinicalDocumentPage($link, $flatten = false)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $link,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$this->getAuthentication(),
                'Cookie: dtCookie=5CF2D18D631F6D578123C785EF66ECEA|RUM+Default+Application|1'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function getVitalsConfiguration($flatten = false)
    {

        $vitalsConfigurationModelsApi = $this->client->getPracticeidChartConfigurationVitals($this->practiceid);

        $vitalsConfigurationModels = [];

        foreach ($vitalsConfigurationModelsApi as $vitalsConfigurationModelApi) {
            $vitalsConfigurationModels[] =
                VitalsConfiguration::createFromApiObject(
                    $vitalsConfigurationModelApi
                );
        }


        if ($flatten) {
            return array_column($vitalsConfigurationModels, 'attributes', 'abreviation');
        }

        return $vitalsConfigurationModels;
    }

    public function createVitals($internalEncounterId, $encounterId, $vitals, $posting){

        $this->client->postPracticeidChartEncounterEncounteridVitals($this->practiceid, $encounterId, $vitals);
        $getVitals = $this->client->getPracticeidChartEncounterEncounteridVitals($this->practiceid, $encounterId);

        if(!empty($getVitals)){
            $readingsMatrix = [];

            foreach ($getVitals as $vitals) {
                foreach ($vitals->readings as $key => $reading) {
                    $readingsMatrix[$reading['clinicalelementid']][$reading['readingid']] = $reading;
                    $readingsMatrix[$reading['clinicalelementid']][$reading['readingid']]['abbreviation'] = $vitals->abbreviation;
                    $readingsMatrix[$reading['clinicalelementid']][$reading['readingid']]['key'] = $vitals->key;
                    $readingsMatrix[$reading['clinicalelementid']][$reading['readingid']]['ordering'] = $vitals->ordering;
                }
            }

            $clinicalelementArr = [];


            $encounterVitals = new EncounterVitals();
            $encounterVitals->posting = $posting;
            $encounterVitals->encounter_id = $internalEncounterId;
            $encounterVitals->save();

            foreach($readingsMatrix as $clinicalelementid => $readings){
                $clinicalelementArr[$clinicalelementid] = max(array_keys($readings));

                $vitalExists = Vitals::find()
                    ->where( [ 'vitalid' => $readingsMatrix[$clinicalelementid][$clinicalelementArr[$clinicalelementid]]['vitalid'] ] )
                    ->exists();

                if(!$vitalExists){
                    $vital =
                        Vitals::createFromApiObject(
                            $readingsMatrix[$clinicalelementid][$clinicalelementArr[$clinicalelementid]]
                        );

                    $vital->link('encounterVital', $encounterVitals);
                    $vital->save();

                }

            }

            return $encounterVitals;
        }

    }

    public function updateVital($encounterId, $vitalId, $value)
    {
        $vitalUpdateApiModel = $this->client->putPracticeidChartEncounterEncounteridVitalsVitalid($this->practiceid, $encounterId, $vitalId, ['value'=> $value]);

        if($vitalUpdateApiModel->success){
            $vital = Vitals::findOne(['vitalid' => $vitalId]);

            $vital->value = $value;
            $vital->save();

            return $vital;
        }

    }

    public function retrieveAllergySubscriptionStatus()
    {
        $subscriptionStatusApi = $this->client->getPracticeidChartHealthhistoryAllergiesChangedSubscription($this->practiceid);

        return $subscriptionStatusApi;
    }

    public function allergiesSubscription($event)
    {
        $subscriptionStatusApi = $this->client->postPracticeidChartHealthhistoryAllergiesChangedSubscription($this->practiceid,
            [
                'eventname' => $event,
            ]
        );

        return $subscriptionStatusApi;
    }

    public function allergyChanges(): array
    {
        $changedAllergies = $this->client->getPracticeidChartHealthhistoryAllergiesChanged($this->practiceid);

        $changedAllergiesResult = [];
        try {
            foreach( $changedAllergies->allergies as $allergyApi ) {
                $allergyModel = $this->obtainAllergy($allergyApi->allergenid, $allergyApi);
                $changedAllergiesResult[] = [$allergyModel->id, $allergyModel->externalId, $allergyModel->save()];
            }
        } catch(\Exception $e) {
            throw $e;//TODO handle this
        }

        return $changedAllergiesResult;
    }

    public function retrieveVaccineSubscriptionStatus()
    {
        $subscriptionStatusApi = $this->client->getPracticeidChartHealthhistoryVaccineChangedSubscription($this->practiceid);

        return $subscriptionStatusApi;
    }

    public function vaccinesSubscription($event)
    {
        $subscriptionStatusApi = $this->client->postPracticeidChartHealthhistoryVaccineChangedSubscription($this->practiceid,
            [
                'eventname' => $event,
            ]
        );

        return $subscriptionStatusApi;
    }

    public function vaccineChanges(): array
    {
        $changedVaccines = $this->client->getPracticeidChartHealthhistoryVaccineChanged($this->practiceid);
        $changedVaccinesResult = [];
        try {
            foreach( $changedVaccines->vaccines as $vaccineApi ) {
                $vaccineModel = $this->obtainVaccine($vaccineApi->vaccineid, $vaccineApi);
                $changedVaccinesResult[] = [$vaccineModel->id, $vaccineModel->externalId, $vaccineModel->save()];
            }
        } catch(\Exception $e) {
            throw $e;//TODO handle this
        }

        return $changedVaccinesResult;
    }


    public function createMedication($patient, $medication)
    {
        $medicationModelApi =
            $this->client->postPracticeidChartPatientidMedications(
                $this->practiceid,
                $patient->externalId,
                $medication->toArray()
            );

        return $this->retrieveMedication(
            $patient,
            $medicationModelApi->medicationentryid,
            $medication->toArray()['medicationid']
        );
    }

    public function retrieveMedication($patient, $medicationentryid, $medicationid)
    {
        $medicationModelApi = $this->client->getPracticeidChartPatientidMedications(
            $this->practiceid,
            $patient->externalId,
            ['departmentid' => $patient->departmentid]
        );

        $medicationByMedicationId = array_filter($medicationModelApi->medications,function($m)use($medicationid){
            return $m[0]['medicationid'] == $medicationid;
        });

        $medication = array_filter(end($medicationByMedicationId),function($m)use($medicationentryid){
            return $m['medicationentryid'] == $medicationentryid;
        });

        $medicationModel = Medication::find()
            ->where(['externalId' => $medicationentryid])
            ->one();

        if (!$medicationModel) {
            return Medication::createFromApiObject(end($medication));
        }

        return $medicationModel->loadApiObject(end($medication));
    }

    /**
     * @return Medication
     */

    public function updateMedication($medication, $updateMedication)
    {

        $this->client->putPracticeidChartPatientidMedicationsMedicationentryid(
            $this->practiceid,
            $medication->medicationentryid,
            $medication->patient->externalId,
            $updateMedication->toArray()
        );

        return $this->retrieveMedication(
            $medication->patient,
            $medication->medicationentryid,
            $medication->medicationid
        );

    }

    public function retrieveFamilyHealthHistorySubscriptionStatus()
    {
        $subscriptionStatusApi = $this->client->getPracticeidChartHealthhistoryFamilyhistoryChangedSubscription($this->practiceid);
        return $subscriptionStatusApi;
    }

    public function familyHealthSubscription($event)
    {
        $subscriptionStatusApi = $this->client->postPracticeidChartHealthhistoryFamilyhistoryChangedSubscription($this->practiceid,
            [
                'eventname' => $event,
            ]
        );

        return $subscriptionStatusApi;
    }

    public function familyHealthHistoryChanges(): array
    {
        $changedFamilyHistory = $this->client->getPracticeidChartHealthhistoryFamilyhistoryChanged($this->practiceid);
        $changedFamilyHistoryResult = [];
        try {
            foreach($changedFamilyHistory->problems as $familyHistoryApi ) {
                $familyHistoryModel = $this->obtainFamilyHistory($familyHistoryApi->problemId, $familyHistoryApi);
                $changedFamilyHistoryResult[] = [$familyHistoryModel->id, $familyHistoryModel->externalId, $familyHistoryModel->save()];
            }
        } catch(\Exception $e) {
            throw $e;//TODO handle this
        }

        return $changedFamilyHistoryResult;

    }

    /**
     * @return Patient
     */

    public function addAppointmentNote($appointment, $appointmentNote)
    {
        $appointmentNoteModelApi =
            $this->client->postPracticeidAppointmentsAppointmentidNotes(
                $this->practiceid,
                $appointment->externalId,
                $appointmentNote->toArray()
            );

        $appointmentNotesModelsApi = $this->retrieveAppointmentNotes(
            $appointment->externalId
        );

        return AppointmentNote::createFromApiObject(
            end($appointmentNotesModelsApi)
        );

    }

    public function retrieveAppointmentNotes($appointmentId)
    {
        $appointmentNotesModelsApi = $this->client->getPracticeidAppointmentsAppointmentidNotes(
            $this->practiceid,
            $appointmentId
        );

        return $appointmentNotesModelsApi;

    }

    /**
     * @return AppointmentNote
     */

    public function updateAppointmentNote($appointmentNote, $updateAppointmentNote)
    {
        $this->client->putPracticeidAppointmentsAppointmentidNotesNoteid(
            $this->practiceid,
            $appointmentNote->put_appointment200_response->externalId,
            $appointmentNote->externalId,
            $updateAppointmentNote->toArray()
        );

        $appointmentNotesModelsApi = $this->retrieveAppointmentNotes(
            $appointmentNote->put_appointment200_response->externalId
        );

        return $this->obtainAppointmentNote(
            $appointmentNote->externalId,
            ArrayHelper::index($appointmentNotesModelsApi, 'noteid')[$appointmentNote->noteid]
        );

    }

    public function retrieveLabResultSubscriptionStatus()
    {
        $subscriptionStatusApi = $this->client->getPracticeidLabresultsChangedSubscription($this->practiceid);

        return $subscriptionStatusApi;
    }


    public function labResultChanges(): array
    {
        $changedLabResults = $this->client->getPracticeidLabresultsChanged($this->practiceid);
        $changedLabResultResult = [];
        try {
            foreach( $changedLabResults->labresults as $labResultApi ) {
                $labResultModel = $this->obtainLabResult($labResultApi->labresultid, $labResultApi);
                $changedVaccinesResult[] = [$labResultModel->id, $labResultModel->externalId, $labResultModel->save()];
            }
        } catch(\Exception $e) {
            throw $e;//TODO handle this
        }

        return $changedLabResultResult;
    }


    public function getAdminDocuments($patientId, $flatten = false)
    {
        $adminDocumentsModelsApi = $this->client->getPracticeidPatientsPatientidDocumentsAdmin($this->practiceid, $patientId);

        $adminDocumentsModels = [];

        foreach ($adminDocumentsModelsApi as $adminDocumentModelApi) {
            $adminDocumentsModels[] = AdminDocument::createFromApiObject($adminDocumentModelApi);
        }

        return $adminDocumentsModels;
    }


    public function createAdminDocument($patientId, $postAdminDocument)
    {
        $postAdminDocumentsModelsApi = $this->client->postPracticeidPatientsPatientidDocumentsAdmin(
            $this->practiceid,
            $patientId,
            $postAdminDocument->toArray()
        );

        if($postAdminDocumentsModelsApi->success){
            $adminDocumentsModelsApi = $this->client->getPracticeidPatientsPatientidDocumentsAdminAdminid(
                $this->practiceid,
                $postAdminDocumentsModelsApi->adminid,
                $patientId
            );
            $adminDocument = AdminDocument::createFromApiObject($adminDocumentsModelsApi[0]);
            $adminDocument->patientid = $patientId;
            $adminDocument->originaldocument = json_encode($adminDocumentsModelsApi[0]['originaldocument']);
            $adminDocument->save();
            foreach ($adminDocumentsModelsApi[0]['pages'] as $key => $value){
                $pageDetail = AdminDocumentPageDetail::createFromApiObject($value);
                $pageDetail->link("adminDocument", $adminDocument);
                $pageDetail->save();
            }

            return $adminDocument;
        }

        return $postAdminDocument;
    }


    public function getAdminDocumentPage($link, $flatten = false)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $link,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$this->getAuthentication(),
                'Cookie: dtCookie=5CF2D18D631F6D578123C785EF66ECEA|RUM+Default+Application|1'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    /**
     * @return Problem
     */
    public function createProblem($problem, $patient)
    {
        $problemPostApi =
            $this->client->postPracticeidChartPatientidProblems(
                $this->practiceid,
                $patient->externalId,
                $problem->toArray()
            );
        //FIXME if($problemModelApi->success == true)

        $problemGetApi = $this->client->getPracticeidChartPatientidProblems(
            $this->practiceid,
            $patient->externalId,
            ['departmentid' => $patient->departmentid]
        );
        $result = ArrayHelper::index($problemGetApi->problems, 'problemid');
        $problem = Problem::createFromApiObject($result[$problemPostApi->problemid]);
        $problem->link('patient', $patient);
        $problem->save();
        foreach($result[$problemPostApi->problemid]->events as $eventApi) {
//var_dump(__METHOD__.__LINE__,$eventApi);die;
            $event = Event::createFromApiObject($eventApi);
            $event->link('problem', $problem);
            $event->save();
        }

        return $problem;
    }

    /**
     * @return Problem
     */
    public function retrieveProblem($patient, $problemId)
    {
        $problemModelApi = $this->client->getPracticeidChartPatientidProblems(
            $this->practiceid,
            $patient->externalId,
            ['departmentid' => $patient->departmentid]
        );

        $result = ArrayHelper::index($problemModelApi->problems, 'problemid');

        $problem = Problem::find()
            ->where(['externalId' => $problemId])
            ->one();

        if (!$problem) {
            $problem = Problem::createFromApiObject($result[$problemId]);
            foreach($result[$problemId]->events as $eventApi) {
                $event = new Event($eventApi);

            }

            return $problem;
        } else {
            $problem->loadApiObject($result[$problemId]);
        }

        return $problem;
    }

    /**
     * @return Problem
     */
    public function updateProblem($problem, $updateProblem)
    {
        $problemModelApi =
            $this->client->putPracticeidChartPatientidProblemsProblemid(
                $problem->externalId,
                $this->practiceid,
                $problem->patientid,
                $updateProblem->toArray()
            );

        return $this->retrievePatientCase(
            $problem->patientid,
            $problemModelApi->patientcaseid
        );
    }

    /**
     * @return Diagnosis
     */

    public function createDiagnosis($encounter, $diagnosis)
    {
        $diagnosisModelApi =
            $this->client->postPracticeidChartEncounterEncounteridDiagnoses(
                $this->practiceid,
                $encounter->externalId,
                $diagnosis->toArray()
            );

        return $this->retrieveDiagnosis(
            $encounter->externalId,
            $diagnosisModelApi->diagnosisid
        );

    }

    public function retrieveDiagnosis($encounterId, $diagnosisId)
    {
        $diagnosisModelsApi = $this->client->getPracticeidChartEncounterEncounteridDiagnoses(
            $this->practiceid,
            $encounterId
        );

        $diagnosisById = ArrayHelper::index($diagnosisModelsApi, 'diagnosisid');

        $diagnosis = Diagnoses::find()
            ->where(['externalId' => $diagnosisId])
            ->one();

        if (!$diagnosis) {
            return Diagnoses::createFromApiObject($diagnosisById[$diagnosisId]);
        }

        return $diagnosis->loadApiObject($diagnosisById[$diagnosisId]);
    }

    /**
     * @return Diagnoses
     */

    public function updateDiagnosis($diagnosis, $updateDiagnosis)
    {

        $this->client->putPracticeidChartEncounterEncounteridDiagnosesDiagnosisid(
            $this->practiceid,
            $diagnosis->encounter->externalId,
            $diagnosis->externalId,
            $updateDiagnosis->toArray()
        );

        return $this->retrieveDiagnosis(
            $diagnosis->encounter->externalId,
            $diagnosis->externalId
        );
    }

    /**
     * @return Order
     */

    public function createOrderPrescription($encounter, $prescriptionOrder)
    {
        $orderModelApi =
            $this->client->postPracticeidChartEncounterEncounteridOrdersPrescription(
                $this->practiceid,
                $encounter->externalId,
                $prescriptionOrder->toArray()
            );

        return $this->retrieveOrder(
            $encounter->externalId,
            $orderModelApi->documentid
        );

    }

    public function retrieveOrder($encounterId, $orderId)
    {
        $orderModelApi = $this->client->getPracticeidChartEncounterEncounteridOrdersOrderid(
            $this->practiceid,
            $encounterId,
            $orderId
        );

        $order = Order::find()
            ->where(['externalId' => $orderId])
            ->one();

        if (!$order) {
            return Order::createFromApiObject($orderModelApi);
        }

        return $order->loadApiObject($orderModelApi);
    }

    /**
     * @return Order
     */

    public function createOrderImaging($encounter, $orderImaging)
    {
        $orderModelApi =
            $this->client->postPracticeidChartEncounterEncounteridOrdersImaging(
                $this->practiceid,
                $encounter->externalId,
                $orderImaging->toArray()
            );

        return $this->retrieveOrder(
            $encounter->externalId,
            $orderModelApi->documentid
        );

    }

    /**
     * @return Order
     */

    public function createOrderLab($encounter, $orderLab)
    {
        $orderModelApi =
            $this->client->postPracticeidChartEncounterEncounteridOrdersLab(
                $this->practiceid,
                $encounter->externalId,
                $orderLab->toArray()
            );

        return $this->retrieveOrder(
            $encounter->externalId,
            $orderModelApi->documentid
        );

    }

    /**
     * @return Order
     */

    public function createOrderDme($encounter, $orderDme)
    {
        $orderModelApi =
            $this->client->postPracticeidChartEncounterEncounteridOrdersDme(
                $this->practiceid,
                $encounter->externalId,
                $orderDme->toArray()
            );

        return $this->retrieveOrder(
            $encounter->externalId,
            $orderModelApi->documentid
        );

    }

    /**
     * @return Order
     */

    public function createOrderVaccine($encounter, $orderVaccine)
    {
        $orderModelApi =
            $this->client->postPracticeidChartEncounterEncounteridOrdersVaccine(
                $this->practiceid,
                $encounter->externalId,
                $orderVaccine->toArray()
            );

        return $this->retrieveOrder(
            $encounter->externalId,
            $orderModelApi->documentid
        );

    }


    public function createInsuranceImageCard($patientid, $insuranceid, $postInsuranceCard)
    {
        $postInsuranceCardModelsApi = $this->client->postPracticeidPatientsPatientidInsurancesInsuranceidImage(
            $this->practiceid,
            $patientid,
            $insuranceid,
            $postInsuranceCard->toArray()
        );

        return $postInsuranceCardModelsApi;
    }

    public function findPatientBestMatch(\common\components\Athena\searchModels\PatientSearch $patientSearch)
    {
        $patientApi = $this->client->getPracticeidPatientsEnhancedbestmatch($this->practiceid, $patientSearch->toArray());
        if(!empty($patientApi))
            return $this->obtainPatient($patientApi[0]->patientid, $patientApi[0]);

        return false;
    }

    /**
     * @return Order
     */

    public function createOrderPatientInfo($encounter, $orderPatientInfo)
    {
        $orderModelApi =
            $this->client->postPracticeidChartEncounterEncounteridOrdersPatientinfo(
                $this->practiceid,
                $encounter->externalId,
                $orderPatientInfo->toArray()
            );

        return $this->retrieveOrder(
            $encounter->externalId,
            $orderModelApi->documentid
        );

    }

    /**
     * @return Order
     */

    public function createOrderReferral($encounter, $orderReferral)
    {
        $orderModelApi =
            $this->client->postPracticeidChartEncounterEncounteridOrdersReferral(
                $this->practiceid,
                $encounter->externalId,
                $orderReferral->toArray()
            );

        return $this->retrieveOrder(
            $encounter->externalId,
            $orderModelApi->documentid
        );

    }

    /**
     * @return Order
     */

    public function createOrderOther($encounter, $orderOther)
    {
        $orderModelApi =
            $this->client->postPracticeidChartEncounterEncounteridOrdersOther(
                $this->practiceid,
                $encounter->externalId,
                $orderOther->toArray()
            );

        return $this->retrieveOrder(
            $encounter->externalId,
            $orderModelApi->documentid
        );

    }

    /**
     * @return array
     */

    public function searchMedications($searchvalue)
    {
        $medicationModelsApi =
            $this->client->getPracticeidReferenceMedications(
                $this->practiceid,
                [
                    'searchvalue' => $searchvalue
                ]
            );

        $medicationModels = [];

        foreach ($medicationModelsApi as $medicationModelApi) {
            $medicationModels[] =
                MedicationReference::createFromApiObject(
                    $medicationModelApi
                );
        }


        return $medicationModels;

    }

    /**
     * @return array
     */

    public function searchOrderableMedications($searchvalue)
    {
        $orderableMedicationModelsApi =
            $this->client->getPracticeidReferenceOrderPrescription(
                $this->practiceid,
                [
                    'searchvalue' => $searchvalue
                ]
            );

        $orderableMedicationModels = [];

        foreach ($orderableMedicationModelsApi as $orderableMedicationModelApi) {
            $orderableMedicationModels[] =
                OrderableMedication::createFromApiObject(
                    $orderableMedicationModelApi
                );
        }


        return $orderableMedicationModels;

    }

    /**
     * @return array
     */

    public function searchOrderableImagings($searchvalue)
    {
        $orderableImagingModelsApi =
            $this->client->getPracticeidReferenceOrderImaging(
                $this->practiceid,
                [
                    'searchvalue' => $searchvalue
                ]
            );

        $orderableImagingModels = [];

        foreach ($orderableImagingModelsApi as $orderableImagingModelApi) {
            $orderableImagingModels[] =
                OrderableImaging::createFromApiObject(
                    $orderableImagingModelApi
                );
        }


        return $orderableImagingModels;

    }

    /**
     * @return array
     */

    public function searchOrderableLabs($searchvalue)
    {
        $orderableLabModelsApi =
            $this->client->getPracticeidReferenceOrderLab(
                $this->practiceid,
                [
                    'searchvalue' => $searchvalue
                ]
            );

        $orderableLabModels = [];

        foreach ($orderableLabModelsApi as $orderableLabModelApi) {
            $orderableLabModels[] =
                OrderableLab::createFromApiObject(
                    $orderableLabModelApi
                );
        }


        return $orderableLabModels;

    }

    /**
     * @return array
     */

    public function searchOrderableDmes($searchvalue)
    {
        $orderableDmeModelsApi =
            $this->client->getPracticeidReferenceOrderDme(
                $this->practiceid,
                [
                    'searchvalue' => $searchvalue
                ]
            );

        $orderableDmeModels = [];

        foreach ($orderableDmeModelsApi as $orderableDmeModelApi) {
            $orderableDmeModels[] =
                OrderableDme::createFromApiObject(
                    $orderableDmeModelApi
                );
        }


        return $orderableDmeModels;

    }


    public function privacyInformationVerified($patientid, $departmentid)
    {
        $privacyInformationVerfied = $this->client->getPracticeidPatientsPatientidPrivacyinformationverified(
            $this->practiceid,
            $patientid,
            [
                'departmentid'  => $departmentid,
            ]
        );

        return $privacyInformationVerfied;
    }


    public function postPrivacyInformationVerified($patientid, $privacyInformation)
    {
        $privacyInformationVerfied = $this->client->postPracticeidPatientsPatientidPrivacyinformationverified(
            $this->practiceid,
            $patientid,
            $privacyInformation,
        );

        return $privacyInformationVerfied;
    }

    /**
     * @return array
     */

    public function searchOrderableVaccines($searchvalue)
    {
        $orderableVaccineModelsApi =
            $this->client->getPracticeidReferenceOrderVaccine(
                $this->practiceid,
                [
                    'searchvalue' => $searchvalue
                ]
            );

        $orderableVaccineModels = [];

        foreach ($orderableVaccineModelsApi as $orderableVaccineModelApi) {
            $orderableVaccineModels[] =
                OrderableVaccine::createFromApiObject(
                    $orderableVaccineModelApi
                );
        }

        return $orderableVaccineModels;

    }

    /**
     * @return array
     */

    public function searchPatientInfoHandouts($searchvalue)
    {
        $patientInfoHandoutModelsApi =
            $this->client->getPracticeidReferenceOrderPatientinfo(
                $this->practiceid,
                [
                    'searchvalue' => $searchvalue
                ]
            );

        $patientInfoHandoutModels = [];

        foreach ($patientInfoHandoutModelsApi as $patientInfoHandoutModelApi) {
            $patientInfoHandoutModels[] =
                PatientInfoHandout::createFromApiObject(
                    $patientInfoHandoutModelApi
                );
        }

        return $patientInfoHandoutModels;

    }

    /**
     * @return array
     */

    public function searchReferralOrderTypes($searchvalue)
    {
        $referralOrderTypeModelsApi =
            $this->client->getPracticeidReferenceOrderReferral(
                $this->practiceid,
                [
                    'searchvalue' => $searchvalue
                ]
            );

        $referralOrderTypeModels = [];

        foreach ($referralOrderTypeModelsApi as $referralOrderTypeModelApi) {
            $referralOrderTypeModels[] =
                ReferralOrderType::createFromApiObject(
                    $referralOrderTypeModelApi
                );
        }

        return $referralOrderTypeModels;

    }

    /**
     * @return array
     */

    public function searchOtherOrderTypes($searchvalue)
    {
        $otherOrderTypeModelsApi =
            $this->client->getPracticeidReferenceOrderOther(
                $this->practiceid,
                [
                    'searchvalue' => $searchvalue
                ]
            );

        $otherOrderTypeModels = [];

        foreach ($otherOrderTypeModelsApi as $otherOrderTypeModelApi) {
            $otherOrderTypeModels[] =
                OtherOrderType::createFromApiObject(
                    $otherOrderTypeModelApi
                );
        }

        return $otherOrderTypeModels;

    }


    public function getMedicalHistory($patientid, $departmentid)
    {
        $medicalHistoryModelsApi =
            $this->client->getPracticeidChartPatientidMedicalhistory(
                $this->practiceid,
                $patientid,
                ['departmentid' => $departmentid]
            );

        $medicalHistoryModels = [];

        foreach ($medicalHistoryModelsApi as $medicalHistoryModelApi) {
            $medicalHistoryModels[] = MedicalHistory::createFromApiObject(
                $medicalHistoryModelApi
            );
        }

        return $medicalHistoryModels;
    }


    public function getMedicalHistoryQuestionsConfiguration()
    {
        $medicalHistoryConfigurationModelsApi =
            $this->client->getPracticeidChartConfigurationMedicalhistory(
                $this->practiceid
            );

        $questions = [];
        $medicalHistoryConfigurationModel = New MedicalHistoryConfiguration();
        if($medicalHistoryConfigurationModelsApi->totalcount > 0){
            foreach ($medicalHistoryConfigurationModelsApi->questions as $question) {
                $questions[] = MedicalHistoryConfigurationQuestion::createFromApiObject(
                    $question
                );
            }
        }

        return $questions;
    }


    public function getMedicalHistoryForAPatient($patientid, $departmentid)
    {
        $medicalHistoryModelsApi =
            $this->client->getPracticeidChartPatientidMedicalhistory(
                $this->practiceid,
                $patientid,
                ['departmentid'  => $departmentid]
            );

        $questions = [];
        foreach ($medicalHistoryModelsApi->questions as $question) {
            $questions[] = MedicalHistoryQuestion::createFromApiObject(
                $question
            );
        }

        return $questions;
    }

    /* ================================= Begin  Protected methods ============================================== */
    protected function obtainPatient($patientId, PatientApi $patientModelApi): Patient
    {
        $patient = Patient::find()
            ->where(['externalId' => $patientId])
            ->one();

        if (!$patient) {
            return Patient::createFromApiObject($patientModelApi);
        }

        return $patient->loadApiObject($patientModelApi);
    }

    protected function obtainAppointment($appointmentId, AppointmentApi $appointmentModelApi): Appointment
    {
        $appointment = PutAppointment200Response::find()
            ->where(['externalId' => $appointmentId])
            ->one();

        if (!$appointment) {
            return PutAppointment200Response::createFromApiObject($appointmentModelApi);
        }

        return $appointment->loadApiObject($appointmentModelApi);
    }

    protected function obtainEncounter($encounterId, EncounterApi $encounterModelApi): Encounter
    {
        $encounter = Encounter::find()
            ->where(['externalId' => $encounterId])
            ->one();

        if (!$encounter) {
            return Encounter::createFromApiObject($encounterModelApi);
        }

        return $encounter->loadApiObject($encounterModelApi);
    }

    protected function obtainPatientCase($patientCaseId, PatientCaseApi $patientCaseModelApi): PatientCase
    {
        $patientCase = PatientCase::find()
            ->where(['externalId' => $patientCaseId])
            ->one();

        if (!$patientCase) {
            return PatientCase::createFromApiObject($patientCaseModelApi);
        }

        return $patientCase->loadApiObject($patientCaseModelApi);
    }

    protected function obtainMedication($medicationId, MedicationApi $medicationModelApi): Medication
    {
        $medication = Medication::find()
            ->where(['externalId' => $medicationId])
            ->one();

        if (!$medication) {
            return Medication::createFromApiObject($medicationModelApi);
        }

        return $medication->loadApiObject($medicationModelApi);
    }

    protected function obtainProblem($problemId, ProblemApi $problemModelApi): Problem
    {
        $problem = Problem::find()
            ->where(['externalId' => $problemId])
            ->one();

        if (!$problem) {
            return Patient::createFromApiObject($problemModelApi);
        }

        return $problem->loadApiObject($problemModelApi);
    }

    protected function obtainAllergy($allergyId, AllergyApi $allergyModelApi): Allergy
    {
        $allergy = Allergy::find()
            ->where(['externalId' => $allergyId])
            ->one();

        if (!$allergy) {
            return Allergy::createFromApiObject($allergyModelApi);
        }

        return $allergy->loadApiObject($allergyModelApi);
    }

    protected function obtainVaccine($vaccineId, VaccineApi $vaccineModelApi): Vaccine
    {
        $vaccine = Vaccine::find()
            ->where(['externalId' => $vaccineId])
            ->one();

        if (!$vaccine) {
            return Vaccine::createFromApiObject($vaccineModelApi);
        }

        return $vaccine->loadApiObject($vaccineModelApi);
    }

    protected function obtainFamilyHistory($problemId, FamilyHistoryApi $familyHistoryModelApi): FamilyHistory
    {
        $familyHistory = FamilyHistory::find()
            ->where(['externalId' => $problemId])
            ->one();

        if (!$familyHistory) {
            return FamilyHistory::createFromApiObject($familyHistoryModelApi);
        }

        return $familyHistory->loadApiObject($familyHistoryModelApi);
    }

    protected function obtainAppointmentNote($appointmentNoteId, AppointmentNoteApi $appointmentNoteModelApi): AppointmentNote
    {
        $appointmentNote = AppointmentNote::find()
            ->where(['externalId' => $appointmentNoteId])
            ->one();

        if (!$appointmentNote) {
            return AppointmentNote::createFromApiObject($appointmentNoteModelApi);
        }

        return $appointmentNote->loadApiObject($appointmentNoteModelApi);
    }


    protected function obtainLabResult($labResultId, LabResultApi $vaccineModelApi): Vaccine
    {
        $labResult = LabResult::find()
            ->where(['externalId' => $labResultId])
            ->one();

        if (!$labResult) {
            return LabResult::createFromApiObject($vaccineModelApi);
        }

        return $labResult->loadApiObject($vaccineModelApi);
    }


    protected function getAuthentication()
    {
        $dataSession = json_decode($this->client->Authenticate(), TRUE);
        if((int)$dataSession['expirationTime'] < (int)time()){
            $dataSession = json_decode($this->client->Authenticate(TRUE), TRUE);
        }
        return $dataSession['access_token'];
    }
    /* =================================== End  Protected methods ============================================== */
}
