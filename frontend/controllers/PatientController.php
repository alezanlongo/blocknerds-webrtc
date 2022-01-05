<?php

namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\db\Query;

use common\components\AthenaComponent;
use common\components\Athena\models\InsuranceCardImage;
use common\components\Athena\models\PatientInsurance;
use common\components\Athena\models\Patient;
use common\components\Athena\searchModels\PatientSearch;
use common\components\Athena\models\RequestChartAlert;

use common\components\Athena\models\ClinicalDocument;
use common\components\Athena\models\AdminDocument;

class PatientController extends \yii\web\Controller
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

    /**
     * Lists all Patient models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$dataProvider = new ActiveDataProvider([
            'query' => Patient::find(),
        ]);

        return $this->render('/patient/index', [
            'dataProvider' => $dataProvider,
        ]);*/
        $searchModel = new PatientSearch();
      
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionImport()
    {
        $searchModel = new PatientSearch();
        if ($searchModel->load(Yii::$app->request->queryParams)) {
            if($patient = $this->component->findPatientBestMatch($searchModel))
                $patient->save();
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Patient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new Patient;

        if ($model->load(Yii::$app->request->post())) {
            $patient = $this->component->createPatient($model);
            $patient->save();

            $insurance = NULL;
            $patientInsurances = $this->component->getpatientInsurances(
                $patient->externalId,
                $patient->departmentid
            );
            foreach ($patientInsurances as $key => $patientInsurance){
                $insurance = $patientInsurance;
            }

            if(is_null($insurance)){
                $insurance = $this->component->createInsurance(
                    $patient->externalId,
                    true
                );
            }
            $insurance->patient_id = $patient->id;
            $insurance->save();

            return $this->redirect(['view', 'id' => $patient->id]);
        }

        return $this->render('/patient/create', [
            'model'         => $model,
            'departments'   => $this->component->getDepartments(true)
        ]);
    }

    /**
     * Displays a single Patient model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $patient = $this->findPatientModel($id);
        $documents = $this->findDocuments($patient->patientid);
        $documentsTypes = [
            'clinical-document' => 'Clinical Document',
            'admin-document'    => 'Admin Document',
        ];

        $dataProvider = new ActiveDataProvider([
            'query' => PatientInsurance::find()->where(['patient_id' => $id]),
        ]);

        return $this->render('/patient/view', [
            'model'             => $patient,
            'chartAlert'        => $this->component->retrieveChartAlert($patient),
            'dataProvider'      => $dataProvider,
            'documents'         => $documents,
            'documentsTypes'    => $documentsTypes,
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
        /*if (($model = Patient::findOne($id))->with('patient_insurance') !== null) {
            return $model;
        }*/

        if (($model = Patient::find()->where(['id' => $id])->with('insurances')->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
    /**
     * Displays a single Insurance model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewInsurance($id, $patientid)
    {
        $patient = $this->findPatientModel($patientid);
        $insuraceCardImage = $this->findInsuranceCardImage($id);

        return $this->render('/insurance/view', [
            'model'                 => $this->findInsuranceModel($id),
            'patientid'             => $patient->patientid,
            'departmentid'          => $patient->departmentid,
            'insuraceCardImage'     => $insuraceCardImage->toArray()
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

        $model = new PatientInsurance();

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->createInsurance(
                $patient->externalId,
                false,
                $model
            );
            $model->patient_id = $patient->id;
            if($model->save()) {
                return $this->redirect(['view-insurance', 'id' => $model->id]);
            }
        }

        return $this->render('/insurance/create', [
            'model' => $model,
            'patientId' => $patient->externalId,
            'insurancePackages' => $this->component->getInsuranceTopPackages(true)
        ]);
    }

    /**
     * Creates a new Patient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreateChartAlert($patientId)
    {

        $model = new RequestChartAlert;
        $patient = $this->findPatientModel($patientId);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->createChartAlert(
                $patient,
                $model
            );

            return $this->redirect(['view', 'id' => $patient->id]);
        }

        return $this->render('/patient/create-chart-alert', [
            'model' => $model,
            'patient' => $patient,
        ]);
    }


    public function actionUpdate($id)
    {
        $patient = $this->findPatientModel($id);
        $model = new Patient;

        if ($patient->load(Yii::$app->request->post())) {
            $updatePatient = $this->component->updatePatient(
                Yii::$app->request->post(),
                $patient->externalId

            );
            if($updatePatient && $patient->save()){
                return $this->redirect(['view', 'id' => $patient->id]);
            }
        }

        return $this->render('/patient/update', [
            'model' => $patient,
        ]);
    }

    public function actionUpdateInsurance($id)
    {
        $insurance = PatientInsurance::findOne($id);
        $patient = Patient::findOne($insurance->patient_id);
        $model = new PatientInsurance;

        if ($insurance->load(Yii::$app->request->post())) {
            $updateInsurance = $this->component->updateInsurance(
                Yii::$app->request->post(),
                $insurance->externalId,
                $patient->externalId
            );

            if(!empty($insurance) && $insurance->save()){
                return $this->redirect(['view-patient', 'id' => $patient->id]);
            }
        }

        return $this->render('/insurance/update', [
            'model' => $insurance,
            'insurancePackages' => $this->component->getInsuranceTopPackages()
        ]);
    }

    public function actionDeleteInsurance($id)
    {
        $insurance = PatientInsurance::findOne($id);
        $patient = Patient::findOne($insurance->patient_id);

        $deleteInsurance = $this->component->deleteInsurance($insurance->externalId, $patient->externalId);

        if($deleteInsurance){
            $insurance->delete();
        }

        return $this->redirect(['view', 'id' => $patient->id]);
    }

    public function actionPatients($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = ['results'];

        if (!is_null($q)) {

            $patient = (new Query())
                ->select(
                    ["CONCAT(firstname,' ', lastname) as fullname, id as id"]
                )
                ->andWhere(['LIKE', 'firstname', $q])
                ->andWhere(['LIKE', 'lastname', $q])
                ->orWhere(['LIKE', 'lower(firstname)', $q])
                ->orWhere(['LIKE', 'lower(lastname)', $q])
                ->from('patients')->limit(10);
            $out['results'] = array_values($patient->all());
        }

        return $out;
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
        if (($model = PatientInsurance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findDocuments($patiendid)
    {
        $documents = [];
        $clinicalDocuments = ClinicalDocument::find()
            ->where(['patientid' => $patiendid])->all();
        $adminDocuments = AdminDocument::find()
            ->where(['patientid' => $patiendid])->all();

        foreach ($clinicalDocuments as $key => $value){
            $row = [
                'documentsubclass'  => $value->documentsubclass,
                'type'              => "clinical-document",
                'documentID'        => $value->clinicaldocumentid,
                'documentclass'     => $value->documentclass,
                'departmentid'      => $value->departmentid,
                'id'                => $value->id,
            ];
            array_push($documents, $row);
        }

        foreach ($adminDocuments as $key => $value){
            $row = [
                'documentsubclass'  => $value->documentsubclass,
                'type'              => "admin-document",
                'documentID'         => $value->adminid,
                'documentclass'     => $value->documentclass,
                'departmentid'      => $value->departmentid,
                'id'                => $value->id,
            ];
            array_push($documents, $row);
        }

        return $documents;
    }


    protected function findInsuranceCardImage($patiendInsurance_id)
    {
        $documents = [];
        $insuranceCardImage = InsuranceCardImage::find()
            ->where(['patientInsurance_id' => $patiendInsurance_id])->one();

        return $insuranceCardImage;
    }
}
