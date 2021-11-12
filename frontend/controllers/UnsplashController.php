<?php

namespace frontend\controllers;

use common\models\Collection;
use common\models\UnsplashForm;
use DateTime;
use yii\httpclient\Client;
use Exception;
use frontend\models\UnsplashSearchForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class UnsplashController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [];
    }

    public function beforeAction($action): bool
    {
        if ($action->actionMethod === 'actionSearch') {
            $dt = new DateTime();
            Yii::info("action method '{$action->actionMethod}' start: {$dt->format('Y-m-d H:i:s')}");
        }

        return parent::beforeAction($action);
    }


    public function actionIndex()
    {
        $unsplashForm = new UnsplashForm();
        $collections = ArrayHelper::map(Yii::$app->user->identity->userProfile->sets, 'id','title');
        $photos = [];
        if ($this->request->isPost) {
            $unsplashForm->load($this->request->post());
            $photos = UnsplashController::search($unsplashForm->search)['results'];
            // VarDumper::dump($photos, $depth = 10, $highlight = true);
            // die;
        }

        return $this->render('index', [
            "collections" => $collections,
            "model" => $unsplashForm,
            'photos' => $photos,
        ]);
    }


    public static function search($search)
    {
        $server = Yii::$app->params['unsplash.server'];
        $clientId = Yii::$app->params['unsplash.clientId'];
        $client = new Client(['baseUrl' => $server]);
        $response =  $client->get('search/photos', ['client_id' => $clientId, 'query' => $search])->send();

        if (!$response->isOk) {
            return null;
        }

        return $response->getData();
    }


    public static function searchOne(string $photoId)
    {
        $server = Yii::$app->params['unsplash.clientId'];
        $clientId = Yii::$app->params['unsplash.server'];
        $client = new Client(['baseUrl' => $server]);
        $response = $client->get("photos/$photoId", ['client_id' => $clientId])->send();

        if ($response->isOk) {
            $photo = $response->getData();
        }

        return $photo;
    }
}
