<?php

namespace frontend\controllers;

use common\components\Withings\WithingsClient;
use Yii;
use yii\helpers\VarDumper;
use yii\httpclient\Client;
use common\components\Withings\WithingsOauth;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\VerbFilter;
use yii\web\UnprocessableEntityHttpException;

class WithingController extends \yii\web\Controller
{
    public $baseUrl = "https://account.withings.com/";
    public $clientId;
    public $customerSecret;

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($action->id == 'callback') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function init()
    {
        parent::init();
        $this->clientId = Yii::$app->params['withings.clientId'];
        $this->customerSecret = Yii::$app->params['withings.consumerSecret'];
    }

    public function actionIndex()
    {
        $url = (new WithingsOauth)->getAuthenticationCode();

        return $this->redirect($url);
    }

    public function actionCallback(string $code = null, string $state = null)
    {
        $response = (new WithingsOauth)->requestToken($code);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->redirect('/');
    }

    public function actionRefreshToken()
    {
        $response = (new WithingsOauth)->requestRefreshToken();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $response;

        // VarDumper::dump($response, $depth = 10, $highlight = true);
        // die;
    }

    public function actionMeasureGetmeas()
    {
        $client = new WithingsClient();

        return $client->measureGetmeas([
            'action' => 'getmeas',
        ]);
    }

    // public function actionGetDataHashed()
    // {
    //     $nonce         = $this->requestNonce();
    //     VarDumper::dump($nonce, $depth = 10, $highlight = true);
    //     die;
    //     $signed_params = array(
    //         'action'     => 'activate',
    //         'client_id'  => $this->clientId,
    //         'nonce'      => $nonce,
    //     );
    //     ksort($signed_params);
    //     $data = implode(",", $signed_params);
    //     $signature = hash_hmac('sha256', $data, $this->customerSecret);
    //     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    //     return [
    //         'signature' => $signature,
    //         'nonce' => $nonce,
    //     ];
    // }

    // public function actionGetDataHashed()
    // {
    //     $nonce = $this->getNonce();
    //     //Yii::$app->security->generateRandomString(12);

    // }

    // private function buildSignature(string $action, int $time)
    // {
    //     $signed_params = array(
    //         'action'     => $action,
    //         'client_id'  => $this->clientId,
    //         'timestamp'      => $time,
    //     );
    //     ksort($signed_params);
    //     $data = implode(",", $signed_params);

    //     return hash_hmac('sha256', $data, $this->customerSecret);
    // }

    // public function actionGetSignature($action)
    // {
    //     $signature = $this->buildSignature($action);
    //     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    //     return ['signature' => $signature];
    // }

    // public function actionGetNonce()
    // {
    //     $action = 'getnonce';
    //     $time = time();
    //     $signature = $this->buildSignature($action, $time);
    //     $params = [
    //         'action' => $action,
    //         'client_id' => $this->clientId,
    //         'timestamp' => $time,
    //         'signature' => $signature,
    //     ];
    //     $response  = $this->doRequest('v2/signature', $params);

    //     VarDumper::dump($response, $depth = 10, $highlight = true);
    //     die;
    //     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    //     return [
    //         'data' => $response,

    //     ];
    // }

    // private function doRequest(string $resource, array $params = [], string $method = 'POST')
    // {
    //     $client = new Client(['baseUrl' => $this->baseUrl]);
    //     $response = $client->post($resource, $params)->send();
    //     if ($response->isOk) {

    //         VarDumper::dump("seems good", $depth = 10, $highlight = true);
    //         VarDumper::dump($response, $depth = 10, $highlight = true);
    //         die;
    //         return $response->data;
    //     }


    //     // VarDumper::dump("bad request", $depth = 10, $highlight = true);

    //     // VarDumper::dump($client, $depth = 10, $highlight = true);
    //     // VarDumper::dump($response, $depth = 10, $highlight = true);
    //     // die;
    //     return null;
    // }
}

// GET SIGNATURE
 // $client_secret =  Yii::$app->params['withings.consumerSecret'];
        // $client_id     = Yii::$app->params['withings.clientId'];
        // $nonce         = 'The nonce I retrieved using service: Signature v2 - Getnonce';
        
        // $signed_params = array(
        //   'action'     => 'activate',
        //   'client_id'  => $client_id,
        //   'nonce'      => $nonce,
        // );   
        // ksort($signed_params);
        // $data = implode(",", $signed_params);
        // $signature = hash_hmac('sha256', $data, $client_secret);
        
        // $call_post_params = array(
        //   // Set the generated signature
        //   'signature'    => $signature,
          
        //   // Set the signed parameters as clear text in the call post parameters
        //   'action'       => 'activate',
        //   'client_id'    => $client_id,
        //   'nonce'        => $nonce,
          
        //   // Set other parameters requested to call the service (here we are calling "User v2 - Activate") 
        //   'redirect_uri' => 'https://www.withings.com',
        //   'birthdate'    => 1563746400
        //   // [...]
        // );
