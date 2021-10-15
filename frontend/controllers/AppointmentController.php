<?php

namespace frontend\controllers;

use Yii;
use common\components\Athena\models\Patient;
use common\components\Athena\models\PutAppointment200Response;
use common\components\Athena\models\RequestCreateAppointment;
use common\components\AthenaComponent;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class AppointmentController extends \yii\web\Controller
{
    private $component;

    public function init()
    {
        parent::init();
        $practiceId = Yii::$app->user->identity->ext_practice_id;
        $this->component = Yii::createObject(AthenaComponent::class);
        $this->component->setPracticeid($practiceId);
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
            'query' => PutAppointment200Response::find(),
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
        $model = new RequestCreateAppointment;
        $patient = Patient::findOne($patientid);

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->createAppointment(
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
            'patient' => $patient
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
        if (($model = PutAppointment200Response::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
