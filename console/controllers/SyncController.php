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
    public $component;

    const ACTIVE_STATUS = 'ACTIVE';

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
        //$this->component = Yii::$app->athenaComponent;
        $this->component->setPracticeid($practiceId);
        try {
            $subscriptionStatus = $this->component->retrievePatientSubscriptionStatus();
            $updateEventSubscription = false;
            if( $subscriptionStatus->status == self::ACTIVE_STATUS ) {
                $updateEventSubscription = true;
            } else {
                foreach( $subscriptionStatus->subscriptions as $event) {
                    if( $event['eventname'] == self::PATIENT_EVENTS['UPDATE'] )
                        $updateEventSubscription = true;
                }
            }
            if( !$updateEventSubscription )
                $this->component->patientsSubscription(self::PATIENT_EVENTS['UPDATE']);

            $this->patientChanges();
        } catch(\Exception  $e) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        return ExitCode::OK;
    }
}
