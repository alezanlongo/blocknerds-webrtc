<?php

namespace frontend\controllers;

use Yii;
use common\components\Athena\models\Insurance;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InsuranceController implements the CRUD actions for Insurance model.
 */
class InsuranceController extends Controller
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
     * Lists all Insurance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Insurance::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Insurance model.
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
     * Creates a new Insurance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($patientId)
    {
        if(!$patientId){
            throw new \yii\web\BadRequestHttpException();
        }

        $model = new Insurance();

        if ($model->load(Yii::$app->request->post())) {

            $patientId = Yii::$app->request->post('Insurance')['patientId'];
            $model = $this->component->createInsurance(
                $model,
                $patientId
            );
            if($model->save()) {
                return $this->redirect(['appointment/create', 'patientId' => $patientId]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'patientId' => $patientId,
            'insurancePackages' => $this->component->getInsurancepackages(true)
        ]);
    }

    /**
     * Updates an existing Insurance model.
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
     * Deletes an existing Insurance model.
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
     * Finds the Insurance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Insurance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Insurance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
