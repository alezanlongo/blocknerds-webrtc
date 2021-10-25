<?php

namespace frontend\controllers;

use Yii;
use common\components\AthenaComponent;
use common\components\Athena\models\Patient;
use common\components\Athena\models\PatientCase;
use common\components\Athena\models\RequestClosePatientCase;
use common\components\Athena\models\RequestCreatePatientCase;
use common\components\Athena\models\RequestReassignPatientCase;
use yii\data\ActiveDataProvider;

class PatientCaseController extends \yii\web\Controller
{
    private $component;

    public function init()
    {
        parent::init();
        if($user = Yii::$app->user->identity)
        {
            $practiceId = $user->ext_practice_id;
            $this->component = Yii::createObject(AthenaComponent::class);
            $this->component->setPracticeid($practiceId);
        }
    }

    /**
     * Lists all Appointments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PatientCase::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Patient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate($patientid)
    {
        $model = new RequestCreatePatientCase;
        $patient = Patient::findOne($patientid);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->createPatientCase(
                $model,
                $patient->externalId
            );
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                var_dump($model->getErrors());die;
            }
        }


        return $this->render('create', [
            'model' => $model,
            'providers' => $this->component->getProviders(true),
            'departments' => $this->component->getDepartments(true),
            'patient' => $patient,
            'documentsources' => $this->getDocumentSources(),
            'documentsubclasses' => $this->getDocumentSubclasses(),
        ]);
    }

    /**
     * Reassigns an existing Patient Case model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionReassign($id)
    {
        $model = new RequestReassignPatientCase;

        if ($model->load(Yii::$app->request->post())) {
            $patientCase = $this->findModel($id);
            $model = $this->component->reassignPatientCase(
                $patientCase,
                $model,
            );
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                var_dump($model->getErrors());die;
            }
        }

        return $this->render('reassign', [
            'usernames' => $this->component->getProvidersUsernames(true),
            'model' => $model,
        ]);
    }

    /**
     * Closes an existing Patient Case model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionClose($id)
    {
        $model = new RequestClosePatientCase;
        $patientCase = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->closePatientCase(
                $patientCase,
                $model,
            );
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                var_dump($model->getErrors());die;
            }
        }

        return $this->render('close', [
            'closeReasons' => $this->component->getCloseReasons($patientCase->externalId,true),
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Patient Case model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new RequestCreatePatientCase;
        $patientCase = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->updatePatientCase(
                $patientCase,
                $model,
            );
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'patientCase' => $patientCase,
            'providers' => $this->component->getProviders(true),
            'documentsources' => $this->getDocumentSources(),
            'documentsubclasses' => $this->getDocumentSubclasses(),
        ]);
    }

    /**
     * Displays a single Appointment model.
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
     * Finds the Appointment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Appointment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PatientCase::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function getDocumentSources()
    {
        return [
            'PATIENT',
            'CAREGIVER',
            'PARTNER',
            'PHARMACY',
            'LAB',
            'PCP',
            'SPECIALIST',
            'STAFF',
            'HOSPITAL',
            'OTHER',
            'PORTAL',
            'Live Operator',
        ];
    }

    protected function getDocumentSubclasses()
    {
        return [
            'PATIENTCASE',
            'ADMINISTRATIVE',
            'BILLING',
            'CLINICALQUESTION',
            'ELECTRONICMEDICALRECORDS',
            'MEDICALRECORDS',
            'NEWRX',
            'OTHER',
            'PATIENTNOSHOW',
            'OTHER',
            'REFRERRAL',
            'REFILL',
        ];
    }
}
