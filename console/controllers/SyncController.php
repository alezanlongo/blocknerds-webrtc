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

    const PATIENTCASE_EVENTS = [
        'ADD'               => 'PatientCaseAdd',
        'UPDATE'            => 'PatientCaseUpdate',
        'ACTIONUPDATE'      => 'PatientCaseActionUpdate',
        'NOTIFY'            => 'PatientCaseNotifyPatient',
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
                $eventSubscription = \stdClass::class;
                foreach( $subscriptionStatus->subscriptions as $event) {
                    switch ($event['eventname']){
                        case self::APPOINTMENT_EVENTS['SCHEDULEAPPOINTMENT']:
                            $eventSubscription = $this->component->appointmentsSubscription(self::APPOINTMENT_EVENTS['SCHEDULEAPPOINTMENT']);
                        break;
                        case self::APPOINTMENT_EVENTS['CHECKIN']:
                            $eventSubscription = $this->component->appointmentsSubscription(self::APPOINTMENT_EVENTS['CHECKIN']);
                        break;
                        case self::APPOINTMENT_EVENTS['CHECKOUT']:
                            $eventSubscription = $this->component->appointmentsSubscription(self::APPOINTMENT_EVENTS['CHECKOUT']);
                        break;
                        case self::APPOINTMENT_EVENTS['UPDATEAPPOINTMENT']:
                            $eventSubscription = $this->component->appointmentsSubscription(self::APPOINTMENT_EVENTS['UPDATEAPPOINTMENT']);
                        break;
                        case self::APPOINTMENT_EVENTS['CANCELAPPOINTMENT']:
                            $eventSubscription = $this->component->appointmentsSubscription(self::APPOINTMENT_EVENTS['CANCELAPPOINTMENT']);
                        break;
                        case self::APPOINTMENT_EVENTS['UPDATEREMINDERCALL']:
                            $eventSubscription = $this->component->appointmentsSubscription(self::APPOINTMENT_EVENTS['UPDATEREMINDERCALL']);
                        break;
                        case self::APPOINTMENT_EVENTS['UPDATESUGGESTEDOVERBOOKING']:
                            $eventSubscription = $this->component->appointmentsSubscription(self::APPOINTMENT_EVENTS['UPDATESUGGESTEDOVERBOOKING']);
                        break;
                        case self::APPOINTMENT_EVENTS['FREEZEAPPOINTMENT']:
                            $eventSubscription = $this->component->appointmentsSubscription(self::APPOINTMENT_EVENTS['FREEZEAPPOINTMENT']);
                        break;
                        case self::APPOINTMENT_EVENTS['UNFREEZEAPPOINTMENT']:
                            $eventSubscription = $this->component->appointmentsSubscription(self::APPOINTMENT_EVENTS['UNFREEZEAPPOINTMENT']);
                        break;
                        case self::APPOINTMENT_EVENTS['DELETEAPPOINTMENT']:
                            $eventSubscription = $this->component->appointmentsSubscription(self::APPOINTMENT_EVENTS['DELETEAPPOINTMENT']);
                        break;
                        case self::APPOINTMENT_EVENTS['ADDAPPOINTMENTSLOT']:
                            $eventSubscription = $this->component->appointmentsSubscription(self::APPOINTMENT_EVENTS['ADDAPPOINTMENTSLOT']);
                        break;
                    }

                    if(property_exists($eventSubscription, 'succcess')){
                        $updateEventSubscription = true;
                    }else{
                        break;
                    }
                }
            }

            $changedAppointmentResult = $this->component->appointmentChanges();
            echo Table::widget([
                'headers' => [
                    'AppointmentID', 'AppointmentExternalID', 'DB Result',
                    'EncounterID', 'EncounterExternalID', 'DB Result'
                ],
                'rows' => $changedAppointmentResult,
            ]);
        } catch(\Exception  $e) {
            echo $e->getMessage()."\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        return ExitCode::OK;
    }

    public function actionPatientCase($practiceId)
    {
        $this->component->setPracticeid($practiceId);
        try {
            $subscriptionStatus = $this->component->retrievePatientCaseSubscriptionStatus();
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
                $this->component->patientCasesSubscription(self::PATIENTCASE_EVENTS['UPDATE']);

            $changedPatiendCasesResult = $this->component->patientCasesChanges();
            echo Table::widget([
                'headers' => ['ID', 'ExternalID', 'DB Result'],
                'rows' => $changedPatiendCasesResult,
            ]);
        } catch(\Exception  $e) {
            echo $e->getMessage()."\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        return ExitCode::OK;
    }

    public function actionProblem($practiceId)
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
}
