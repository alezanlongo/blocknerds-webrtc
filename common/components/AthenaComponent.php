<?php
namespace common\components;

use Yii;
use common\components\Athena\AthenaClient;
use common\components\Athena\apiModels\AppointmentApi;
use common\components\Athena\apiModels\EncounterApi;
use common\components\Athena\apiModels\MedicationApi;
use common\components\Athena\apiModels\PatientApi;
use common\components\Athena\apiModels\PatientCaseApi;
use common\components\Athena\apiModels\ProblemApi;
use common\components\Athena\apiModels\VaccineApi;
use common\components\Athena\apiModels\FamilyHistoryApi;
use common\components\Athena\models\ActionNote;
use common\components\Athena\models\Appointment;
use common\components\Athena\models\ChartAlert;
use common\components\Athena\models\Checkin;
use common\components\Athena\models\ClinicalDocument;
use common\components\Athena\models\ClinicalDocumentPageDetail;
use common\components\Athena\models\CloseReason;
use common\components\Athena\models\Department;
use common\components\Athena\models\Encounter;
use common\components\Athena\models\EncounterVitals;
use common\components\Athena\models\Medication;
use common\components\Athena\models\Patient;
use common\components\Athena\models\PatientCase;
use common\components\Athena\models\PatientLocation;
use common\components\Athena\models\PatientStatus;
use common\components\Athena\models\Problem;
use common\components\Athena\models\Provider;
use common\components\Athena\models\PutAppointment200Response;
use common\components\Athena\models\Readings;
use common\components\Athena\models\Vaccine;
use common\components\Athena\models\Vitals;
use common\components\Athena\models\VitalsConfiguration;
use common\components\Athena\models\insurance;
use common\components\Athena\models\insurancePackages;
use common\components\Athena\models\FamilyHistory;
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

        return $this->retrievePatient($patientModelApi[0]->patientid);
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