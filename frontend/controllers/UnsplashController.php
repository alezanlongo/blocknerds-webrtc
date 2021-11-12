<?php

namespace frontend\controllers;

use common\models\Collection;
use DateTime;
use yii\httpclient\Client;
use Exception;
use frontend\models\UnsplashSearchForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
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
        return [
          
        ];
    }

    public function beforeAction($action): bool {
        if ($action->actionMethod === 'actionSearch') {
            $dt = new DateTime();
            Yii::info("action method '{$action->actionMethod}' start: {$dt->format('Y-m-d H:i:s')}");
        }
        
        return parent::beforeAction($action);
    }


    public function actionIndex()
    {
        $collections = Yii::$app->user->identity->getCollections()->asArray()->all();

        return $this->render('index', [
            "collections" => $collections
        ]);
    }

    public function actionSearch()
    {
        $search = Yii::$app->request->post()["search"];
        $response = UnsplashController::search($search);
        $photos = [];

        if ($response->isOk) {
            $photos = $response->getData()["results"];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            "search" => $search,
            "data" => $photos
        ];
    }


    public static function search($search)
    {
        $server = "https://api.unsplash.com/";
        $clientId = "Fvl6_IMfndHATC4uEIs5XDwdSFbnBaLam_PWIHSOq-o";
        $client = new Client(['baseUrl' => $server]);

        return $client->get('search/photos', ['client_id' => $clientId, 'query' => $search])->send();
    }


    public static function searchOne(string $photoId)
    {
        $server = "https://api.unsplash.com/";
        $clientId = "Fvl6_IMfndHATC4uEIs5XDwdSFbnBaLam_PWIHSOq-o";
        $client = new Client(['baseUrl' => $server]);
        $response = $client->get("photos/$photoId", ['client_id' => $clientId])->send();

        if ($response->isOk) {
            $photo = $response->getData();
        }

        return $photo;
    }

    public static function downloadOne(string $photoId)
    {
        $server = "https://api.unsplash.com/";
        $clientId = "Fvl6_IMfndHATC4uEIs5XDwdSFbnBaLam_PWIHSOq-o";
        $client = new Client(['baseUrl' => $server]);
        $response = $client->get("photos/$photoId/download", ['client_id' => $clientId])->send();

        if ($response->isOk) {
            $photo = $response->getData();
        }

        return $photo["url"] ?? null;
    }
}
