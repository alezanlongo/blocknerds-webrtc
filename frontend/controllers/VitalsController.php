<?php

namespace frontend\controllers;

use Yii;
use common\components\Athena\models\Encounter;
use common\components\Athena\models\Vitals;
use common\components\Athena\models\EncounterVitals;
use common\components\Athena\models\VitalsReference;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\AthenaComponent;

/**
 * VitalsController implements the CRUD actions for Vitals model.
 */
class VitalsController extends Controller
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Vitals models.
     * @return mixed
     */
    public function actionIndex($encounterId)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => EncounterVitals::find()->where(['encounter_id' => $encounterId]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'encounterId' => $encounterId
        ]);
    }

    /**
     * Displays a single Vitals model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $vitals = Vitals::find()
            ->where( [ 'encounterVital_id'=> $id ] )
            ->all();


        $vitaltsByClinicalId = [];

        $vitalsConfiguration = VitalsReference::find();
        foreach ($vitals as $vital){
            $vitaltsByClinicalId[$vital->clinicalelementid] = $vital;
            $vitalsConfiguration->orWhere(['clinicalelementid' => $vital->clinicalelementid]);
        }

        return $this->render('view', [
            'vitalsConfiguration' => $vitalsConfiguration->all(),
            'vitaltsByClinicalId' => $vitaltsByClinicalId
        ]);
    }

    /**
     * Creates a new Vitals model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($encounterId)
    {

        $vitalsConfiguration = VitalsReference::find()->all();
        $encounter = Encounter::find()->where(['id' => $encounterId])->one();

        $model = new Vitals;
        $readings = [];
        if (Yii::$app->request->post()) {
            $group = null;
            $vitalsToSave = [];
            $i = -1;

            foreach (Yii::$app->request->post('Vitals') as $clinicalElementId => $value){

                if(!empty($value)|| $value == 0){
                    $vitalGroup = Yii::$app->request->post('VitalsGroup')['_'.$clinicalElementId];

                    if($group != $vitalGroup){
                        $i++;
                        $group = $vitalGroup;
                        $vitalsToSave = [];
                    }

                    $vitalsToSave[] = ['clinicalelementid' => $clinicalElementId, 'value' => $value];
                    $readings[$i] = $vitalsToSave;
                }
            }

            $readings = json_encode($readings);

            $posting = EncounterVitals::find()->where(['encounter_id' => $encounterId])->max('posting') + 1;
            $encounterVital = $this->component->createVitals($encounterId, $encounter->encounterid, ['vitals' => $readings], $posting);


            return $this->redirect(['view', 'id' => $encounterVital->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'vitalsConfiguration' => $vitalsConfiguration
        ]);
    }

    /**
     * Updates an existing Vitals model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $vitals = Vitals::find()
            ->where( [ 'encounterVital_id'=> $id ] )
            ->all();


        if (Yii::$app->request->post()) {
            foreach (Yii::$app->request->post('Vitals') as $vitalId => $value){
                foreach ($vitals as $vital){
                    if($vitalId == $vital->vitalid){
                        if($vital->value != $value){
                            $this->component->updateVital($vital->sourceid, $vitalId, $value);
                        }
                    }
                }

            }

            return $this->redirect(['view', 'id' => $id]);
        }

        $vitaltsByClinicalId = [];

        $vitalsConfiguration = VitalsReference::find();
        foreach ($vitals as $vital){
            $vitaltsByClinicalId[$vital->clinicalelementid] = $vital;
            $vitalsConfiguration->orWhere(['clinicalelementid' => $vital->clinicalelementid]);
        }

        return $this->render('update', [
            'vitalsConfiguration' => $vitalsConfiguration->all(),
            'vitaltsByClinicalId' => $vitaltsByClinicalId
        ]);
    }

    /**
     * Deletes an existing Vitals model.
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
     * Finds the Vitals model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vitals the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vitals::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
