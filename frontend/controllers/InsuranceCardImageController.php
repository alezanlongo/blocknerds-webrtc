<?php

namespace frontend\controllers;

use common\components\Athena\models\PostInsuranceCardImage;
use common\components\AthenaComponent;
use Yii;
use common\components\Athena\models\InsuranceCardImage;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * InsuranceCardImageController implements the CRUD actions for InsuranceCardImage model.
 */
class InsuranceCardImageController extends Controller
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
     * Lists all InsuranceCardImage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => InsuranceCardImage::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InsuranceCardImage model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $patientid)
    {
        $link = Yii::$app->params['athena_url']."v1/".$this->component->getPracticeid()."/patients/".$patientid."/insurances/".$id."/image?jpegoutput=true";

        header("Content-type: image/jpeg");
        echo $this->component->getClinicalDocumentPage($link);
        exit();
    }

    /**
     * Creates a new InsuranceCardImage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($patientid, $departmentid, $insuranceid, $patientInsurance_id)
    {
        $model = new PostInsuranceCardImage();
        $dataPost = Yii::$app->request->post();
        $dataPost['departmentid'] = $departmentid;

        if ($model->load($dataPost)) {
            $document = UploadedFile::getInstanceByName('document');
            $filename = $document->name;
            $path_parts = pathinfo($filename);

            $fc = file_get_contents($document->tempName);
            $model->image = chunk_split(base64_encode($fc));

            $response = $this->component->createInsuranceImageCard($patientid, $insuranceid, $model);
            if($response->success){
                $insuraceCardImage = $this->findInsuranceCardImage($patientInsurance_id);
                if(count($insuraceCardImage->toArray()) == 0){
                    $insuraceCardImage = new InsuranceCardImage();
                }
                $insuraceCardImage->image = substr($model->image, 0, 10);
                $insuraceCardImage->insuranceid = $insuranceid;
                $insuraceCardImage->patientInsurance_id= $patientInsurance_id;
                $insuraceCardImage->save();

                return $this->redirect([
                    'view',
                    'id'            => $insuranceid,
                    'patientid'     => $patientid
                ]);
            }else{
                return $this->render('create', [
                    'model'         => $model,
                    'departmentid'  => $departmentid
                ]);
            }

        }

        return $this->render('create', [
            'model'         => $model,
            'departmentid'  => $departmentid
        ]);
    }

    /**
     * Updates an existing InsuranceCardImage model.
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
     * Deletes an existing InsuranceCardImage model.
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
     * Finds the InsuranceCardImage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InsuranceCardImage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InsuranceCardImage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findInsuranceCardImage($patiendInsurance_id)
    {
        $documents = [];
        $insuranceCardImage = InsuranceCardImage::find()
            ->where(['patientInsurance_id' => $patiendInsurance_id])->one();

        return $insuranceCardImage;
    }
}
