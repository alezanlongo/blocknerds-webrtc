<?php

namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\components\Athena\models\Insurance;
use common\components\Athena\models\Patient;
use yii\web\NotFoundHttpException;

class PatientInsuranceController extends \yii\web\Controller
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

    /**
     * Lists all Patient models.
     * @return mixed
     */
    public function actionListPatients()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Patient::find(),
        ]);

        return $this->render('/patient/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Patient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreatePatient()
    {
        $model = new Patient;

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->createPatient(
                $model
            );

            if($model->save()){
                return $this->redirect(['view-patient', 'id' => $model->id]);
            }

        }

        return $this->render('/patient/create', [
            'model' => $model,
            'departments' => $this->component->getDepartments(true),
        ]);
    }

    /**
     * Displays a single Patient model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewPatient($id)
    {
        return $this->render('/patient/view', [
            'model' => $this->findPatientModel($id),
        ]);
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
        if (($model = Patient::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Lists all Insurance models.
     * @return mixed
     */
    public function actionListInsurances()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Insurance::find(),
        ]);

        return $this->render('/insurance/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Insurance model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewInsurance($id)
    {
        return $this->render('/insurance/view', [
            'model' => $this->findInsuranceModel($id),
        ]);
    }

     /**
     * Creates a new Insurance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateInsurance($patientId)
    {
        if(!$patientId){
            throw new \yii\web\BadRequestHttpException();
        }

        $patient = Patient::find()
            ->where(['id' => $patientId])
            ->one();

        $model = new Insurance();

        if ($model->load(Yii::$app->request->post())) {

            $patientId = Yii::$app->request->post('Insurance')['patientId'];
            $model = $this->component->createInsurance(
                $model,
                $patient->externalId
            );
            if($model->save()) {
                return $this->redirect(['view-insurance', 'id' => $model->id]);
            }
        }

        return $this->render('/insurance/create', [
            'model' => $model,
            'patientId' => $patient->externalId,
            'insurancePackages' => $this->component->getInsurancepackages(true)
        ]);
    }

    /**
     * Finds the Insurance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Insurance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findInsuranceModel($id)
    {
        if (($model = Insurance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}