<?php

namespace frontend\controllers;

use Yii;
use common\components\Athena\models\Encounter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EncounterController implements the CRUD actions for Encounter model.
 */
class EncounterController extends Controller
{
    private $component;

    public function init()
    {
        parent::init();
        $this->component = Yii::$app->athenaComponent;
        $this->component->setPracticeid(195900);
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
}
