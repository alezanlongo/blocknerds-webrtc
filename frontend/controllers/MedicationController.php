<?php

namespace frontend\controllers;

use Yii;
use common\components\AthenaComponent;
use common\components\Athena\models\Medication;
use common\components\Athena\models\MedicationReference;
use common\components\Athena\models\Patient;
use common\components\Athena\models\RequestCreateMedication;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class MedicationController extends \yii\web\Controller
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
     * Lists all Appointments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Medication::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Medication model.
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
     * Creates a new Patient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate($patientid)
    {
        $model = new RequestCreateMedication;
        $patient = Patient::findOne($patientid);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->createMedication(
                $patient,
                $model
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
            'patient' => $patient,
        ]);
    }

    public function actionMedications($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = ['results' => ['medicationid' => '', 'medication' => '']];

        if (!is_null($q)) {

            $medications = MedicationReference::find()
                ->select(['medicationid as id', 'medication'])
                ->andWhere(['LIKE', 'medication', $q])
                ->limit(10);

            $out['results'] = array_values($medications->all());
        }

        return $out;
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
        if (($model = Medication::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
