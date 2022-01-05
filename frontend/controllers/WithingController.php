<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\httpclient\Client;


class WithingController extends \yii\web\Controller
{
    const RESPONSE_TYPE_CODE = "code";
    const REQUEST_TYPE_ACTION = "requesttoken";
    const SCOPE_USER_ACTIVITY = "user.activity";
    const SCOPE_USER_METRICS = "user.metrics";
    const SCOPE_USER_INFO = "user.info";
    const GRANT_TYPE_AUTH_CODE = "authorization_code";

    public function actionIndex()
    {
        $basePath = "https://account.withings.com/";
        $source = "oauth2_user/authorize2";
        $clientId = Yii::$app->params['withings.clientId'];
        
        // $client = new Client(['baseUrl' => $basePath]);
        $state = "something";
        $scopes = self::SCOPE_USER_INFO . ',' . self::SCOPE_USER_METRICS .','.self::SCOPE_USER_ACTIVITY;

        $params = [
            'response_type' => self::RESPONSE_TYPE_CODE,
            'client_id' => $clientId,
            'state' => $state,
            'scope' => $scopes,
            // 'redirect_uri' => "https://localhost/withing/callback",
            'redirect_uri' => "https://www.google.com/?hl=es",
        ];
        $url = $basePath . $source . '?' . urldecode(http_build_query($params));
        return $this->redirect($url);
    }
    public function actionCallback(string $code, string $state)
    {
        $basePath = "https://wbsapi.withings.net/";
        $source = "v2/oauth2";
        $clientId = Yii::$app->params['withings.clientId'];
        $customerSecret = Yii::$app->params['withings.consumerSecret'];
        $nonce = "nonce";
        $signature = "";
        $params = [
            'action' => self::REQUEST_TYPE_ACTION,
            'client_id' => $clientId,
            // 'nonce' => $nonce,
            // 'signature' => $signature,
            'client_secret' => $customerSecret,
            'grant_type' => self::GRANT_TYPE_AUTH_CODE ,
            'code' => $code,
            'redirect_uri' => "https://www.google.com/?hl=es",
        ];
        VarDumper::dump( $params, $depth = 10, $highlight = true);
        die;
        $client = new Client(['baseUrl' => $basePath]);
        $response = $client->post($source, $params)->send();
        if ($response->isOk) {
            VarDumper::dump( ['OK',$response->data], $depth = 10, $highlight = true);
            die;
        }
        VarDumper::dump( ['KO',$response], $depth = 10, $highlight = true);
        die;
    }
}

// GET SIGNATURE
 // $client_secret =  Yii::$app->params['withings.clientId'];
        // $client_id     = Yii::$app->params['withings.consumerSecret'];
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
