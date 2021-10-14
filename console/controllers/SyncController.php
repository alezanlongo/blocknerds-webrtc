<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Usage Example: yii sync/patient 195900
 */
class SyncController extends Controller
{
    const PATIENT_EVENTS = [
        'ADD' => 'AddPatient',
        'DELETE' => 'DeletePatient',
        'UPDATE' => 'UpdatePatient',
        'MERGE' => 'MergePatient',
        'UPDATECUSTOMFIELD' => 'UpdatePatientCustomField',
    ];

    public function init() 
    {
        parent::init();
        $this->component = Yii::$app->athenaComponent;
    }

    public function actionPatient($practiceId)
    {
        $this->component->setPracticeid($practiceId);
        try {
            $this->patientSubscriptionStatus();
            //TODO if !ACTIVE patientsSubscription(PATIENT_EVENTS['ADD'])
            $this->patientChanges();
        } catch(\Exception  $e) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        return ExitCode::OK;
    }

    private function patientSubscriptionStatus()
    {
        //TODO
        //call GET /patients/changed/subscription
    }

    private function patientsSubscription($event)
    {
        //TODO
        //call POST /patients/changed/subscription use PATIENT_EVENTS['ADD']
    }

    private function patientChanges()
    {
        //TODO
        //call GET /patients/changed
        //loop patients
        //upsert by externalId
    }
}
