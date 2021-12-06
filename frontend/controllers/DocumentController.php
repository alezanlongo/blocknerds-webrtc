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
use common\components\Athena\models\AdminDocument;
use common\components\Athena\models\AdminDocumentPageDetail;
use common\components\Athena\models\PostAdminDocument;
use common\components\AthenaComponent;

/**
 * ClinicalDocumentController implements the CRUD actions for ClinicalDocument model.
 */
class DocumentController extends Controller
{
    private $component;
    private $type;

    public function init()
    {
        parent::init();
        if($user = Yii::$app->user->identity){
            $practiceId = $user->ext_practice_id;
            $this->component = Yii::createObject(AthenaComponent::class);
            $this->component->setPracticeid($practiceId);
        }

        $queryParams = Yii::$app->request->getQueryParams(); //var_dump($queryParams);
        $this->type = $queryParams['type'];
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
        switch ($this->type){
            case 'clinical-document':
                $dataProvider = new ActiveDataProvider([
                    'query' => ClinicalDocument::find(),
                ]); //echo"<pre>"; var_dump(ClinicalDocument::find()->all()); exit();
            break;
            case 'admin-document':
                $dataProvider = new ActiveDataProvider([
                    'query' => AdminDocument::find(),
                ]); //echo"<pre>"; var_dump(ClinicalDocument::find()->all()); exit();
            break;
        }

        return $this->render("/".$this->type.'/index', [
            'dataProvider'  => $dataProvider,
            'patientid'     => $patientid,
            'departmentid'  => $departmentid,
            'type'          => $this->type,
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
        switch ($this->type){
            case 'clinical-document':
                $model = $this->findModel($id);
                $pageDetail = $this->findPageDetail($id);
            break;
            case 'admin-document':
                $model = $this->findAdminModel($id);
                $pageDetail = $this->findAdminPageDetail($id);
            break;
        }

        return $this->render("/".$this->type.'/view', [
            'patientid'     => $patientid,
            'model'         => $model,
            'pageDetail'    => $pageDetail,
            'type'          => $this->type
        ]);
    }

    /**
     * Creates a new ClinicalDocument model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($patientid, $departmentid)
    {
        switch ($this->type){
            case 'clinical-document':
                $model = new PostClinicalDocument;
                $documentSubClasses = [
                    'CLINICALDOCUMENT'      => 'CLINICALDOCUMENT',
                    'ADMISSIONDISCHARGE'    => 'ADMISSIONDISCHARGE',
                    'CONSULNOTE'            => 'CONSULNOTE',
                    'MENTALHEALTH'          => 'MENTALHEALTH',
                    'OPERATIVENOTE'         => 'OPERATIVENOTE',
                    'URGENTCARE'            => 'URGENTCARE'
                ];
            break;
            case 'admin-document':
                $model = new PostAdminDocument();
                $documentSubClasses = [
                    'ADMIN'                 => 'ADMIN',
                    'BILLING'               => 'BILLING',
                    'CONSENT'               => 'CONSENT',
                    'HIPAA'                 => 'HIPAA',
                    'INSURANCEAPPROVAL'     => 'INSURANCEAPPROVAL',
                    'INSURANCECARD'         => 'INSURANCECARD',
                    'INSURANCEDENIAL'       => 'INSURANCEDENIAL',
                    'LEGAL'                 => 'LEGAL',
                    'MEDICALRECORDREQ'      => 'MEDICALRECORDREQ',
                    'MUDUNNINGLETTER'       => 'MUDUNNINGLETTER',
                    'REFERRAL'              => 'REFERRAL',
                    'SIGNEDFORMSLETTERS'    => 'SIGNEDFORMSLETTERS',
                    'VACCINATIONRECORD'     => 'VACCINATIONRECORD'
                ];
            break;
        }
        $dataPost = Yii::$app->request->post();

        if ($model->load($dataPost)) {
            $document = UploadedFile::getInstanceByName('document');
            $filename = $document->name;
            $path_parts = pathinfo($filename);
            $model->attachmenttype = strtoupper($path_parts['extension']);

            $fc = file_get_contents($document->tempName);
            $model->attachmentcontents = chunk_split(base64_encode($fc));


            switch ($this->type){
                case 'clinical-document':
                    $model = $this->component->createClinicalDocument($patientid, $model);
                break;
                case 'admin-document':
                    $model = $this->component->createAdminDocument($patientid, $model);
                break;
            }
            return $this->redirect([
                'view',
                'id'            => $model->id,
                'patientid'     => $patientid,
                'departmentid'  => $departmentid,
                'type'          => $this->type
            ]);
        }

        $model->departmentid = $departmentid;

        return $this->render("/".$this->type.'/create', [
            'model'                 => $model,
            'documentSubClasses'    => $documentSubClasses,
            'patientid'             => $patientid,
            'departmentid'          => $departmentid,
            'type'                  => $this->type
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

        return $this->render("/".$this->type.'/update', [
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

        return $this->redirect(["/".$this->type.'/index']);
    }


    /**
     * Displays a single ClinicalDocument model.
     * @param integer $pageid
     * @param integer $patientid
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewPage($pageid)
    {
        switch ($this->type){
            case 'clinical-document':
                $model = $this->findOnePageDetail($pageid);
                $link = $model->href."?filesize=SMALL";
            break;
            case 'admin-document':
                $model = $this->findOneAdminPageDetail($pageid);
                $link = $model->href."?filesize=SMALL";
            break;
        }


        header("Content-type: image/jpeg");
        echo $this->component->getClinicalDocumentPage($link);
        exit();
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


    protected function findAdminModel($id)
    {
        if (($model = AdminDocument::findOne($id)) !== null) {
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


    protected function findOnePageDetail($pageid)
    {
        $clinicalDocumentPageDetail = ClinicalDocumentPageDetail::find()
            ->where(['pageid' => $pageid])->one();

        return $clinicalDocumentPageDetail;
    }


    protected function findAdminPageDetail($clinicalDocument_id)
    {
        $clinicalDocumentPageDetail = AdminDocumentPageDetail::find()
            ->where(['adminDocument_id' => $clinicalDocument_id]);

        return $clinicalDocumentPageDetail->all();
    }


    protected function findOneAdminPageDetail($pageid)
    {
        $clinicalDocumentPageDetail = AdminDocumentPageDetail::find()
            ->where(['pageid' => $pageid])->one();

        return $clinicalDocumentPageDetail;
    }
}
