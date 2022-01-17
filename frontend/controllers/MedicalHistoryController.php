<?php

namespace frontend\controllers;

use common\components\Athena\models\MedicalHistoryQuestion;
use common\components\Athena\models\Patient;
use common\components\Athena\models\PutMedicalHistory;
use common\components\AthenaComponent;
use Yii;
use common\components\Athena\models\MedicalHistory;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MedicalHistoryController implements the CRUD actions for MedicalHistory model.
 */
class MedicalHistoryController extends Controller
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
     * Lists all MedicalHistory models.
     * @return mixed
     */
    public function actionIndex($patientid)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MedicalHistory::find(),
        ]);

        return $this->render('index', [
            'dataProvider'  => $dataProvider,
            'patientid'     => $patientid
        ]);
    }


    public function actionImport($patientid)
    {
        $patient = $this->findPatientModel($patientid);
        $medicalHistory = $this->component->getMedicalHistory($patientid, $patient->patientid, $patient->departmentid);
        $medicalHistory->save();
        $questions = $this->component->getMedicalHistoryQuestions($medicalHistory, $patient->patientid, $patient->departmentid);
        foreach ($questions as $key => $value){
            $value->save();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => MedicalHistory::find(),
        ]);

        return $this->render('index', [
            'dataProvider'  => $dataProvider,
            'patientid'     => $patientid
        ]);
    }

    /**
     * Displays a single MedicalHistory model.
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
     * Creates a new MedicalHistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($patientid)
    {
        $model = new MedicalHistory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MedicalHistory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $patientid
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $patientid)
    {
        $patient = $this->findPatientModel($patientid);
        $questions = $this->component->getMedicalHistoryQuestionsConfiguration();
        $model = $this->findModel($id);
        $medicalHistoryQuestions = $this->findQuestionsModel($id);
        $data = Yii::$app->request->post();

        foreach ($questions as $keyQuesition => $valueQuestion){
            foreach ($medicalHistoryQuestions as $key => $value){
                if($valueQuestion->questionid == $value->questionid){
                    $questions[$keyQuesition]->answer = $value->answer;
                }
            }
        }

        if (count($data) > 0) {
            $jsonQUestion = [];
            foreach ($data['response'] as $key => $value){
                if($value != ''){
                    array_push($jsonQUestion, [
                        'questionid'    => $key,
                        'answer'        => $value
                    ]);
                }
            }
            $putMedicalHistory = $this->component->putMedicalHistory([
                'departmentid'  => $patient->departmentid,
                'sectionnote'   => $data['MedicalHistory']['sectionnote'],
                'questions'     => json_encode($jsonQUestion),
            ], $patient->patientid);


            $medicalHistory = $this->component->getMedicalHistory($patientid, $patient->patientid, $patient->departmentid);
            $medicalHistory->save();
            $questions = $this->component->getMedicalHistoryQuestions($medicalHistory, $patient->patientid, $patient->departmentid);
            foreach ($questions as $key => $value){
                $value->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model'                     => $model,
            'questions'                 => $questions,
            'medicalHistoryQuestions'   => $medicalHistoryQuestions
        ]);
    }

    /**
     * Deletes an existing MedicalHistory model.
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

    /**
     * Finds the MedicalHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MedicalHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MedicalHistory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findQuestionsModel($id)
    {
        $questions = MedicalHistoryQuestion::find()->where(['medicalHistory_id' => $id]);
        return $questions->all();
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
