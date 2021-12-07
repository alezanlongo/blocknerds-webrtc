<?php

namespace frontend\controllers;

use Yii;
use common\components\AthenaComponent;
use common\components\Athena\models\Diagnoses;
use common\components\Athena\models\DosageQuantityUnit;
use common\components\Athena\models\Encounter;
use common\components\Athena\models\Frequency;
use common\components\Athena\models\Order;
use common\components\Athena\models\OrderableDme;
use common\components\Athena\models\OrderableImaging;
use common\components\Athena\models\OrderableLab;
use common\components\Athena\models\OrderableMedication;
use common\components\Athena\models\OrderableVaccine;
use common\components\Athena\models\PutAppointment200Response;
use common\components\Athena\models\RequestCreateDiagnosis;
use common\components\Athena\models\RequestCreateOrderDme;
use common\components\Athena\models\RequestCreateOrderImaging;
use common\components\Athena\models\RequestCreateOrderLab;
use common\components\Athena\models\RequestCreateOrderPrescription;
use common\components\Athena\models\RequestCreateOrderVaccine;
use common\components\Athena\models\TotalQuantityUnit;
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
                $model->link('encounter', $encounter);
                return $this->redirect(['view-diagnosis', 'id' => $model->id]);
            }
        }

        return $this->render('create-diagnosis', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Diagnoses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateDiagnosis($id)
    {
        $model = new RequestCreateDiagnosis;
        $diagnosis = $this->findDiagnosisModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->updateDiagnosis(
                $diagnosis,
                $model
            );
            if($model->save()){
                return $this->redirect(['view-diagnosis', 'id' => $model->id]);
            }
        }

        return $this->render('update-diagnosis', [
            'model' => $model,
            'diagnosis' => $diagnosis,
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
     * Create Order (Prescription) model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCreateOrderPrescription($id)
    {
        $model = new RequestCreateOrderPrescription;
        $encounter = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->createOrderPrescription(
                $encounter,
                $model
            );
            if($model->save()){
                return $this->redirect(['view-order-prescription', 'id' => $model->id]);
            }
        }

        return $this->render('create-order-prescription', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewOrderPrescription($id)
    {
        return $this->render('order', [
            'model' => $this->findOrderModel($id),
        ]);
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionOrders()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find(),
        ]);

        return $this->render('orders', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create Order (Imaging) model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCreateOrderImaging($id)
    {
        $model = new RequestCreateOrderImaging;
        $encounter = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->createOrderImaging(
                $encounter,
                $model
            );
            if($model->save()){
                return $this->redirect(['view-order-prescription', 'id' => $model->id]);
            }
        }

        return $this->render('create-order-imaging', [
            'model' => $model,
        ]);
    }

    /**
     * Create Order (Lab) model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCreateOrderLab($id)
    {
        $model = new RequestCreateOrderLab;
        $encounter = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->createOrderLab(
                $encounter,
                $model
            );
            if($model->save()){
                return $this->redirect(['view-order-prescription', 'id' => $model->id]);
            }
        }

        return $this->render('create-order-lab', [
            'model' => $model,
        ]);
    }

    /**
     * Create Order (DME) model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCreateOrderDme($id)
    {
        $model = new RequestCreateOrderDme;
        $encounter = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->createOrderDme(
                $encounter,
                $model
            );
            if($model->save()){
                return $this->redirect(['view-order-prescription', 'id' => $model->id]);
            }
        }

        return $this->render('create-order-dme', [
            'model' => $model,
        ]);
    }

    /**
     * Create Order (Vaccine) model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCreateOrderVaccine($id)
    {
        $model = new RequestCreateOrderVaccine;
        $encounter = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->createOrderVaccine(
                $encounter,
                $model
            );
            if($model->save()){
                return $this->redirect(['view-order-prescription', 'id' => $model->id]);
            }
        }

        return $this->render('create-order-vaccine', [
            'model' => $model,
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

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findOrderModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionOrderableMedications($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = ['results' => ['ordertypeid' => '', 'name' => '']];

        if (!is_null($q)) {

            $orderableMedications = OrderableMedication::find()
                ->select(['ordertypeid as id', 'name'])
                ->andWhere(['LIKE', 'name', $q])
                ->limit(10);

            $out['results'] = array_values($orderableMedications->all());
        }

        return $out;
    }

    public function actionFrequencies($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = ['results' => ['id' => '', 'frequency' => '']];

        if (!is_null($q)) {

            $frequencies = Frequency::find()
                ->select(['frequency'])
                ->andWhere(['LIKE', 'frequency', $q])
                ->limit(10);

            $out['results'] = array_map(function($frequency){
                return [
                    'id' => $frequency->frequency,
                    'frequency' => $frequency->frequency
                ];
            },$frequencies->all());

        }

        return $out;
    }

    public function actionDosageUnits($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = ['results' => ['id' => '', 'quantityunit' => '']];

        if (!is_null($q)) {

            $dosageUnits = DosageQuantityUnit::find()
                ->select(['quantityunit'])
                ->andWhere(['LIKE', 'quantityunit', $q])
                ->limit(10);

            $out['results'] = array_map(function($dosageUnit){
                return [
                    'id' => $dosageUnit->quantityunit,
                    'quantityunit' => $dosageUnit->quantityunit
                ];
            },$dosageUnits->all());
        }

        return $out;
    }

    public function actionTotalQuantity($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = ['results' => ['id' => '', 'quantityunit' => '']];

        if (!is_null($q)) {

            $totalQuantities = TotalQuantityUnit::find()
                ->select(['quantityunit'])
                ->andWhere(['LIKE', 'quantityunit', $q])
                ->limit(10);

            $out['results'] = array_map(function($totalQuantity){
                return [
                    'id' => $totalQuantity->quantityunit,
                    'quantityunit' => $totalQuantity->quantityunit
                ];
            },$totalQuantities->all());

        }

        return $out;
    }

    public function actionOrderableImagings($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = ['results' => ['ordertypeid' => '', 'name' => '']];

        if (!is_null($q)) {

            $orderableImagings = OrderableImaging::find()
                ->select(['ordertypeid as id', 'name'])
                ->andWhere(['LIKE', 'name', $q])
                ->limit(10);

            $out['results'] = array_values($orderableImagings->all());
        }

        return $out;
    }

    public function actionOrderableLabs($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = ['results' => ['ordertypeid' => '', 'name' => '']];

        if (!is_null($q)) {

            $orderableLabs = OrderableLab::find()
                ->select(['ordertypeid as id', 'name'])
                ->andWhere(['LIKE', 'name', $q])
                ->limit(10);

            $out['results'] = array_values($orderableLabs->all());
        }

        return $out;
    }

    public function actionOrderableDmes($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = ['results' => ['ordertypeid' => '', 'name' => '']];

        if (!is_null($q)) {

            $orderableDmes = OrderableDme::find()
                ->select(['ordertypeid as id', 'name'])
                ->andWhere(['LIKE', 'name', $q])
                ->limit(10);

            $out['results'] = array_values($orderableDmes->all());
        }

        return $out;
    }

    public function actionOrderableVaccines($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = ['results' => ['ordertypeid' => '', 'name' => '']];

        if (!is_null($q)) {

            $orderableDmes = OrderableVaccine::find()
                ->select(['ordertypeid as id', 'name'])
                ->andWhere(['LIKE', 'name', $q])
                ->limit(10);

            $out['results'] = array_values($orderableDmes->all());
        }

        return $out;
    }
}
