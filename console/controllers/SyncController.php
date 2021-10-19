<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\console\widgets\Table;

/**
 * Usage Example: yii sync/patient 195900
 */
class SyncController extends Controller
{
    public $component;

    const ACTIVE_STATUS = 'ACTIVE';

    const PATIENT_EVENTS = [
        'ADD'               => 'AddPatient',
        'DELETE'            => 'DeletePatient',
        'UPDATE'            => 'UpdatePatient',
        'MERGE'             => 'MergePatient',
        'UPDATECUSTOMFIELD' => 'UpdatePatientCustomField',
    ];

    const APPOINTMENT_EVENTS = [
        'SCHEDULEAPPOINTMENT'           => 'ScheduleAppointment',
        'CHECKIN'                       => 'CheckIn',
        'CHECKOUT'                      => 'CheckOut',
        'UPDATEAPPOINTMENT'             => 'UpdateAppointment',
        'CANCELAPPOINTMENT'             => 'CancelAppointment',
        'UPDATEREMINDERCALL'            => 'UpdateReminderCall',
        'UPDATESUGGESTEDOVERBOOKING'    => 'UpdateSuggestedOverbooking',
        'FREEZEAPPOINTMENT'             => 'FreezeAppointment',
        'UNFREEZEAPPOINTMENT'           => 'UnfreezeAppointment',
        'DELETEAPPOINTMENT'             => 'DeleteAppointment',
        'ADDAPPOINTMENTSLOT'            => 'AddAppointmentSlot',
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

            $changedPatiendResult = $this->component->patientChanges();
            echo Table::widget([
                'headers' => ['ID', 'ExternalID', 'DB Result'],
                'rows' => $changedPatiendResult,
            ]);
        } catch(\Exception  $e) {
            echo $e->getMessage()."\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        return ExitCode::OK;
    }


    public function actionAppointment($practiceId)
    {
        $this->component->setPracticeid($practiceId);
        try {
            $subscriptionStatus = $this->component->retrieveAppointmentSubscriptionStatus();
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
                $this->component->appointmentsSubscription(self::PATIENT_EVENTS['UPDATE']);

            $changedAppointmentResult = $this->component->appointmentChanges();
            echo Table::widget([
                'headers' => ['ID', 'ExternalID', 'DB Result'],
                'rows' => $changedAppointmentResult,
            ]);
        } catch(\Exception  $e) {
            echo $e->getMessage()."\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        return ExitCode::OK;
    }
}
