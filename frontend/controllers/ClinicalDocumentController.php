<?php

namespace frontend\controllers;


use spec\Prophecy\Doubler\Generator\Node\ReturnTypeNodeSpec;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use common\components\Athena\models\ClinicalDocument;
use common\components\Athena\models\ClinicalDocumentPageDetail;
use common\components\Athena\models\PostClinicalDocument;
use common\components\AthenaComponent;

/**
 * ClinicalDocumentController implements the CRUD actions for ClinicalDocument model.
 */
class ClinicalDocumentController extends Controller
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
     * Lists all ClinicalDocument models.
     * @return mixed
     */
    public function actionIndex($patientid, $departmentid)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ClinicalDocument::find(),
        ]); //echo"<pre>"; var_dump(ClinicalDocument::find()->all()); exit();

        return $this->render('index', [
            'dataProvider'  => $dataProvider,
            'patientid'     => $patientid,
            'departmentid'  => $departmentid
        ]);
    }

    /**
     * Displays a single ClinicalDocument model.
     * @param integer $id
     * @param integer $patientid
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $patientid)
    {
        /*$dataProviderPageDetail = new ActiveDataProvider([
            'query' => $this->findPageDetail($id),
        ]);*/

        return $this->render('view', [
            'patientid'     => $patientid,
            'model'         => $this->findModel($id),
            'pageDetail'    => $this->findPageDetail($id)
        ]);
    }

    /**
     * Creates a new ClinicalDocument model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($patientid, $departmentid)
    {
        $model = new PostClinicalDocument;
        $dataPost = Yii::$app->request->post();

        if ($model->load($dataPost)) {
            $document = UploadedFile::getInstanceByName('document');
            $filename = $document->name;
            $path_parts = pathinfo($filename);
            $model->attachmenttype = strtoupper($path_parts['extension']);

            $fc = file_get_contents($document->tempName);
            $model->attachmentcontents = chunk_split(base64_encode($fc));

            $model = $this->component->createClinicalDocument($patientid, $model);
            return $this->redirect([
                'view',
                'id'        => $model->id,
                'patientid' => $patientid
            ]);
        }

        $model->departmentid = $departmentid;
        $documentSubClasses = [
            'CLINICALDOCUMENT'      => 'CLINICALDOCUMENT',
            'ADMISSIONDISCHARGE'    => 'ADMISSIONDISCHARGE',
            'CONSULNOTE'            => 'CONSULNOTE',
            'MENTALHEALTH'          => 'MENTALHEALTH',
            'OPERATIVENOTE'         => 'OPERATIVENOTE',
            'URGENTCARE'            => 'URGENTCARE'
        ];

        return $this->render('create', [
            'model'                 => $model,
            'documentSubClasses'    => $documentSubClasses,
        ]);
    }

    /**
     * Updates an existing ClinicalDocument model.
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
     * Deletes an existing ClinicalDocument model.
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
     * Displays a single ClinicalDocument model.
     * @param integer $pageid
     * @param integer $patientid
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewPage($pageid, $patientid, $clinicalDocumentid)
    {
        $this->component->getClinicalDocumentPage($patientid, $clinicalDocumentid, $pageid);

        /*return $this->render('view', [
            'patientid'     => $patientid,
            'model'         => $this->findModel($id),
            'pageDetail'    => $dataProviderPageDetail
        ]);*/
    }

    /**
     * Finds the ClinicalDocument model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClinicalDocument the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClinicalDocument::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findPageDetail($clinicalDocument_id)
    {
        $clinicalDocumentPageDetail = ClinicalDocumentPageDetail::find()
            ->where(['clinicalDocument_id' => $clinicalDocument_id]);

        return $clinicalDocumentPageDetail->all();
    }
}
