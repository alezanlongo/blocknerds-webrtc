<?php

namespace frontend\controllers;

use Yii;
use common\models\Photo;
use common\models\Set;
use Exception;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Response;

/**
 * ProtoController implements the CRUD actions for Photo model.
 */
class PhotoController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Photo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Photo::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Photo model.
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
     * Creates a new Photo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Photo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionAdd()
    {
        if (!$this->request->isPost) {
            throw new NotFoundHttpException('Page not found.');
        }

        $photoUnsplush = UnsplashController::searchOne($this->request->post('photo_id'));
        $setId = intval($this->request->post('set_id'));
        $set = Set::findOne(['id' => $setId, 'profile_id' =>  Yii::$app->user->identity->userProfile->id]);

        if (empty($photoUnsplush) || empty($set)) {
            throw new NotFoundHttpException("Photo or Set not found");
        }
        try {
           
            $size = $this->request->post('size_image_default') ?? UnsplashController::SIZE_IMAGE_DEFAULT;
            $photo = new Photo();
            $photo->set_id = $set->id;
            $photo->photo_id = $photoUnsplush['id'];
            $photo->description = $photoUnsplush['description'];
            $photo->alt_description = $photoUnsplush['alt_description'];
            $photo->url = $photoUnsplush['urls'][$size];

            $photo->save();
            Yii::$app->session->setFlash('success', "Photo added to set $set->title.");
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', "Error adding photo.");

            throw $e;
        }
        // VarDumper::dump( $photoUnsplush, $depth = 10, $highlight = true);
        // die;

        // Yii::$app->response->format = Response::FORMAT_JSON;
        // return $this->request->post();
        return $photoUnsplush['id'];
    }

    /**
     * Updates an existing Photo model.
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
     * Deletes an existing Photo model.
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
     * Finds the Photo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Photo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Photo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
