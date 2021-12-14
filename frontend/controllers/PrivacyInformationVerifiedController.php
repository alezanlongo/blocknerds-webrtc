<?php

namespace frontend\controllers;


use common\components\Athena\models\PostPrivacyInformationVerified;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

use common\components\AthenaComponent;
use common\components\Athena\models\Patient;

class PrivacyInformationVerifiedController extends \yii\web\Controller
{
    private $component;

    public function init()
    {
        parent::init();
        if($user = Yii::$app->user->identity){
            $practiceId = $user->ext_practice_id;
            $this->component = Yii::createObject(AthenaComponent::class);
            $this->component->setPracticeid($practiceId);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                "class" => AccessControl::class,
                "rules" => [
                    [
                        'allow' => true,
                        'roles' => ["@"],
                    ]
                ],
            ],
        ];
    }


    public function actionIndex($patientid)
    {
        $patient = $this->findPatientModel($patientid);
        $pricavyInformation = $this->component->privacyInformationVerified(
            $patient->patientid,
            $patient->departmentid
        );
        return $this->render('index',[
            'pricavyInformation'    => $pricavyInformation,
            'departmentid'          => $patient->departmentid,
            'patientid'             => $patient->patientid
        ]);
    }


    public function actionCreate()
    {
        $data = Yii::$app->request->post();
        $data['signaturedatetime'] = date('m/d/Y H:i:s');

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response = $this->component->postPrivacyInformationVerified(
            $data['patientid'],
            $data
        );

        return $response[0]->toArray();
    }


    /**
     * Finds the Patient model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Patient the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPatientModel($id)
    {
        if (($model = Patient::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
