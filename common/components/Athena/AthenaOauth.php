<?php
namespace common\components\Athena;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\Exception as DBException;
use yii\httpclient\Client;
use yii\httpclient\Exception as HttpClientException;


class AthenaOauth
{
    const URL_SERVICE_AUTH = "oauth2/v1/token";

    /**
     * AthenaOauth constructor.
     */
    public function Authenticate()
    {
        $data = [];
        $success =  FALSE;
        $session = Yii::$app->session;

        if(!is_null($session->get('athenaAuth'))){
            $data = $session->get('athenaAuth');
        }else{
            $link = Yii::$app->params['athena_url'].self::URL_SERVICE_AUTH;
            $client = new Client();
            $request = $client->createRequest();
            $request->setMethod('POST')
                ->setUrl($link)
                ->setHeaders([
                    'Content-type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . base64_encode(Yii::$app->params['athena_key'] . ':' . Yii::$app->params['athena_secret']),
                ])
                ->setData([
                    'grant_type'    => 'client_credentials',
                    'scope'         => 'athena/service/Athenanet.MDP.*',
                ]);

            try {
                $response = $request->send();
            } catch (\Exception $e) {
                throw new \yii\web\ServerErrorHttpException($e->getMessage());
            }

            $dataResponse = json_decode($response->getContent(), TRUE);
            $dataStatusCodeRespose =  $response->getStatusCode();
            if ($response->isOk) {
                $success = TRUE;
                $dataResponse['created_time'] = date('Y-m-d H:i:s');
                $data = [
                    'message'       => "",
                    'data'          => $dataResponse,
                    'success'       => $success,
                    'statusCode'    => $dataStatusCodeRespose
                ];
                $session->set('athenaAuth', $data);
            }else{
                $error = '';
                if(isset($dataResponse['error'])){
                    $error = $dataResponse['error'];
                    $error = (isset($dataResponse['detailedmessage'])) ? $error." ".$dataResponse['detailedmessage'] : $error;
                }
                throw new \yii\web\BadRequestHttpException($error);
            }
        }

        return $data;
    }


    public function callMethod($path, $action, array $params = [])
    {
        $data = [];
        $success =  FALSE;
        $session = Yii::$app->session;

        $dataSession = $this->Authenticate();
        $interval = time() - strtotime($dataSession['data']['created_time']);
        if((int)$interval < (int)$dataSession['data']['expires_in']){
            $session->remove('athenaAuth');
            $dataSession = $this->Authenticate();
        }

        $link = Yii::$app->params['athena_url'].$path;
        $client = new Client();
        $request = $client->createRequest();
        $request->setMethod($action)
            ->setUrl($link)
            ->setHeaders([
                'Authorization' => 'Bearer ' . $dataSession['data']['access_token'],
            ]);
        if(count($params) > 0){
            $request->setData($params);
        }

        try {
            $response = $request->send();
        }catch(\Exception $e){
            throw new \yii\web\ServerErrorHttpException($e->getMessage());
        }

        $dataResponse = json_decode($response->getContent(), TRUE);
        $dataStatusCodeRespose =  $response->getStatusCode();
        if ($response->isOk) {
            $success = TRUE;
            $data = [
                'message'       => "",
                'data'          => $dataResponse,
                'success'       => $success,
                'statusCode'    => $dataStatusCodeRespose
            ];
        }else{
            $error = '';
            if(isset($dataResponse['error'])){
                $error = $dataResponse['error'];
                $error = (isset($dataResponse['detailedmessage'])) ? $error." ".$dataResponse['detailedmessage'] : $error;
            }
            throw new \yii\web\BadRequestHttpException($error);
        }


        return $data;
    }
}