<?php

namespace frontend\controllers;

use Yii;
use common\components\AthenaComponent;
use common\components\Athena\models\Diagnoses;
use common\components\Athena\models\Encounter;
use common\components\Athena\models\PutAppointment200Response;
use common\components\Athena\models\RequestCreateDiagnosis;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * EncounterController implements the CRUD actions for Encounter model.
 */
class EncounterController extends Controller
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
            'verbs' => [
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

    /**
     * Lists all Encounter models.
     * @return mixed
     */
    public function actionIndex($patientid, $departmentid)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Encounter::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Encounter model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Encounter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Encounter();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Encounter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $departmentId)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->updateEncounter($model);
            if($model->save()){
                $appointment = $this->findModelAppointment($model->appointmentid);
                $appointment->encounterid = $model->encounterid;
                $appointment->save();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model'             => $model,
            'patientLocations'  => $this->component->getPatientLocations($departmentId, TRUE),
            'patientStatuses'   => $this->component->getPatientStatuses(TRUE),
        ]);
    }

    /**
     * Deletes an existing Encounter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionStartCheckin()
    {
        $error = FALSE;
        $message = '';
        $data = Yii::$app->request->post()['PutAppointment200Response'];
        $data = [
            'patientid'     => $data['patientid'],
            'departmentid'  => $data['departmentid'],
            'appointmentid' => $data['appointmentid'],
        ];

        $startCheckin = $this->component->startCheckin($data['appointmentid']);
        if(!$startCheckin['success']){
            $error =  !$error;
            $message = 'We have haven some problems please, try again';
        }

        return $this->render('start-checkin', [
            'patientid'     => $data['patientid'],
            'departmentid'  => $data['departmentid'],
            'appointmentid' => $data['appointmentid'],
            'error'         => $error,
            'message'       => $message
        ]);
    }


    public function actionCheckin($patientid, $departmentid, $appointmentid)
    {
        $error = FALSE;
        $message = '';

        $checkin = $this->component->checkin($appointmentid);
        if($checkin['success']){
            $dataApiEncounters = $this->component->getEcounters($patientid, $departmentid, $appointmentid);
            foreach ($dataApiEncounters as $apiEncounter){
                $model = $this->component->createEncounter($apiEncounter->toArray());
                $model->save();

                $appointment = $this->findModelAppointment($appointmentid);
                $appointment->encounterid = $apiEncounter->encounterid;
                $appointment->save();
            }

            return $this->redirect([
                'encounter/index',
                'patientid'     => $patientid,
                'departmentid'  => $departmentid
            ]);
        }else{
            $error =  !$error;
            $message = 'We have haven some problems please, try again';
        }

        return $this->render('checkin', [
            'patientid'     => $patientid,
            'departmentid'  => $departmentid,
            'appointmentid' => $appointmentid,
            'error'         => $error,
            'message'       => $message
        ]);
    }

    /**
     * Add note to Appointment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCreateDiagnosis($id)
    {
        $model = new RequestCreateDiagnosis;
        $encounter = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->createDiagnosis(
                $encounter,
                $model
            );
            if($model->save()){
                return $this->redirect(['view-diagnosis', 'id' => $model->id]);
            }
        }

        return $this->render('create-diagnosis', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Diagnosis model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewDiagnosis($id)
    {
        return $this->render('diagnosis', [
            'model' => $this->findDiagnosisModel($id),
        ]);
    }

    /**
     * Lists all Diagnoses models.
     * @return mixed
     */
    public function actionDiagnoses()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Diagnoses::find(),
        ]);

        return $this->render('diagnoses', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Finds the Encounter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Encounter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Encounter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findModelAppointment($id)
    {
        if (($model = PutAppointment200Response::find()->where(['externalId' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Diagnoses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Diagnoses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findDiagnosisModel($id)
    {
        if (($model = Diagnoses::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
