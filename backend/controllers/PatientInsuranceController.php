<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Patient Insurance controller
 */
class PatientController extends Controller
{
    /**
     *
     *
     * @return
     */
    public function actionCreatePatientInsurance(
        AthenaService $service
    )
    {
        $patientInsuranceApiModel = $service->createPatientInsurance(
            $request->post('insurancePackage'),
            $request->post('insuranceNumber'),
            $request->post('holderName'),
            $request->post('holderLastName'),
            $request->post('sex')
        );

        return PatientInsurance::createFromApiObject($patientInsuranceApiModel);
    }

}
