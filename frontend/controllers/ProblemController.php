<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\components\AthenaComponent;
use common\components\Athena\models\Problem;
use common\components\Athena\models\Patient;
use common\components\Athena\models\RequestCreateProblem;

class ProblemController extends Controller
{
    private $component;

    const LATERALITY = [
        'LEFT' => 'Left',
        'RIGHT' => 'Right',
        'BILATERAL' => 'Bilateral',
    ];

    const STATUS = [
        'ACUTE' => 'Acute',
        'CHRONIC' => 'Chronic',
    ];//FIXME should be in the Model

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
     * @return mixed
     */
    public function actionIndex($patientid)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Problem::find(['patient_id' => $patientid]),
        ]);

        return $this->render('index', [
            'patientId' => $patientid,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Problem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate($patientid)
    {
        $model = new RequestCreateProblem;
        $patient = Patient::findOne($patientid);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->createProblem(
                $model,
                $patient
            );

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'patient' => $patient,
            'departments' => $this->component->getDepartments(true),
            'laterality' => self::LATERALITY,
            'status'    => self::STATUS,
        ]);
    }

    /*
     * Updates an existing Problem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     *
    public function actionUpdate($id)
    {
        $model = new RequestCreateProblem;
        $problem = $this->findModel($id);
        $model->laterality = $problem->laterality;
        $model->note = $problem->note;
        $model->startdate = $problem->startdate;
        $model->status = $problem->status;

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->updateProblem(
                $problem,
                $model,
            );
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'problem' => $problem,
            //'patient' => $problem->patient,
            'departments' => $this->component->getDepartments(true),
            'laterality' => self::LATERALITY,
            'status'    => self::STATUS,
        ]);
    }
    */

    /**
     * Displays a single Problem model.
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
     * Finds the Problem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Problem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Problem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
