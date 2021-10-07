<?php

namespace frontend\controllers;

use Yii;
use common\components\Athena\models\Checkin;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CheckinController implements the CRUD actions for Checkin model.
 */
class CheckinController extends Controller
{
    private $component;

    function __construct($id, $module)
    {
        parent::__construct($id, $module);
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Checkin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Checkin::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Checkin model.
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
     * Creates a new Checkin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /*$model = new Checkin();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);*/
        $data = Yii::$app->request->post()['PutAppointment200Response'];

        $data = [
            'patientid' => $data['patientid'],
            'departmentid'  => $data['departmentid'],
            'appointmentid' => $data['appointmentid'],
        ];

        $startCheckin = $this->component->startCheckin($data['appointmentid']);
        if($startCheckin['success']){
            $checkin = $this->component->checkin($data['appointmentid']);
            if($checkin['success']){
                $dataApiEncounters = $this->component->getEcounters($data['patientid'], $data['departmentid'], $data['appointmentid']);
                foreach ($dataApiEncounters as $apiEncounter){
                    $model = $this->component->createEncounter($apiEncounter->toArray());
                    $model->save();
                }

                return $this->redirect([
                    'encounter/index',
                    'patientid'     => $data['patientid'],
                    'departmentid'  => $data['departmentid']
                ]);
            }else{
                echo 'fallo checkin';
            }
        }else{
            echo 'fallo start checkin';
        }
    }

    /**
     * Updates an existing Checkin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Checkin model.
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
     * Finds the Checkin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Checkin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Checkin::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
