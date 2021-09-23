<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Patient controller
 */
class PatientController extends Controller
{

    /**
     *
     *
     * @return
     */
    public function actionCreatePatient(
        AthenaClient $client
    )
    {
        $patientApiModel = $client->createPatient([
                'name' => $request->post('name'),
                'lastName' =>  $request->post('lastName'),
                'birthdayDate' => $request->post('birthdayDate'),
                'departmentId' => $request->post('departmentId'),
                'email' => $request->post('email'),
            ]
        );

        try {
            return Patient::createFromApiObject($patientsApiModel);
        } catch (Exception $e) {

        }

    }

}
