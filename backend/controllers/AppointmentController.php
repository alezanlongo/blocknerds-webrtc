<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Appointment controller
 */
class AppointmentController extends Controller
{
    /**
     *
     *
     * @return
     */
    public function actionCreateAppointment(
        AthenaService $service
    )
    {
        $appointmentApiModel = $service->createAppointment(
            $request->post('departmentId'),
            $request->post('patientId'),
            $request->post('appointmentDate'),
            $request->post('appointmentTime'),
            $request->post('providerId')
        );

        return Appointment::createFromApiObject($patientsApiModel);
    }

}
