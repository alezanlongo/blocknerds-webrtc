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

    private const SOURCE_SEARCH_PHOTOS = 'search/photos';
    private const SOURCE_SEARCH_PHOTO = 'photos/';
    const SIZE_IMAGE_DEFAULT = 'small';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                "class" => AccessControl::class,
                "only" => ['index'],
                "rules" => [
                    [
                        'allow' => true,
                        'roles' => ["@"],
                    ]
                ],
            ],
        ];
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
        $collections = ArrayHelper::map(Yii::$app->user->identity->userProfile->sets, 'id', 'title');
        $photos = [];
        if ($this->request->isPost) {
            $unsplashForm->load($this->request->post());
            $photos = $this->search($unsplashForm->search);
            // VarDumper::dump($photos, $depth = 10, $highlight = true);
            // die;
        }

        return $this->render('index', [
            "collections" => $collections,
            "model" => $unsplashForm,
            'photos' => $photos,
        ]);
    }


    public static function search(string $search): ?array
    {
        $response =  self::doRequest(self::SOURCE_SEARCH_PHOTOS, $search);

        if (empty($response) || !array_key_exists('results', $response)) {
            return null;
        }

        return $response['results'];
    }


    public static function searchOne(string $photoId)
    {
        $response =  self::doRequest(self::SOURCE_SEARCH_PHOTO . $photoId);

        if (empty($response) ) {
            return null;
        }

        return $response;
    }

    private static function doRequest(string $source, ?string $searchParam = null)
    {
        $server = Yii::$app->params['unsplash.server'];
        $clientId = Yii::$app->params['unsplash.clientId'];
        $client = new Client(['baseUrl' => $server]);
        $params = ['client_id' => $clientId];

        if (!empty($searchParam)) {
            $params['query'] =  $searchParam;
        }

        $response = $client->get($source, $params)->send();

        if ($response->isOk) {
            return $response->getData();
        }

        return null;
    }
}
