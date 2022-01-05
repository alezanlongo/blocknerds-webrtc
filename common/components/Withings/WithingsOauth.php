<?php
namespace common\components\Withings;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\Exception as DBException;
use yii\httpclient\Client;
use yii\httpclient\Exception as HttpClientException;

use common\models\Configuration;

class WithingsOauth
{
    const URL_SERVICE_AUTH = "oauth2/v1/token";

    /**
     * WithingsOauth constructor.
     */
    public function Authenticate($expired = FALSE)
    {
        //REFACTORIZAR ESTE VALOR DEL PRACTICE ID
        $data = [];
        $success =  FALSE;

        $configurationModel = Configuration::find()->where([
            'type'          => 'AthenaToken',
            'practiceId' => Yii::$app->params['practiceID'],
        ])->one();
        if(!is_null($configurationModel)){
            if($expired){
                $configurationModel->content = json_encode($this->callAuthenticateAthena());
                $configurationModel->save();
            }
        }else{
            $configurationModel = new Configuration;
            $configurationModel->type = "AthenaToken";
            $configurationModel->content = json_encode($this->callAuthenticateAthena());
            $configurationModel->practiceId = Yii::$app->params['practiceID'];
            $configurationModel->save();
        }

        return $configurationModel->content;
    }


    public function callMethod($path, $action, array $params = [])
    {
        $data = [];
        $success =  FALSE;

        $dataSession = json_decode($this->Authenticate(), TRUE);
        if((int)$dataSession['expirationTime'] < (int)time()){
            $dataSession = json_decode($this->Authenticate(TRUE), TRUE);
        }

        $link = Yii::$app->params['athena_url'].$path;
        $client = new Client([
            'transport' => 'yii\httpclient\CurlTransport'
        ]);
        $request = $client->createRequest();
        $requestOptions = [];
        if(!empty(Yii::$app->params['http_client_timeout'])){
            $requestOptions[CURLOPT_TIMEOUT] = Yii::$app->params['http_client_timeout']; // set timeout to 5 seconds for the case server is not responding
        }
        if(!empty($requestOptions)){
            $request->setOptions($requestOptions);
        }
        $request->setMethod($action)
            ->setUrl($link)
            ->setHeaders([
                'Authorization' => 'Bearer ' . $dataSession['access_token'],
            ]);
        if(count($params) > 0){
            $request->setData($params);
        }

        try {
            $response = $request->send();
        }catch(\Exception $e){
            throw new \yii\web\ServerErrorHttpException($this->handleError($e->getMessage()));
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


    private function callAuthenticateAthena()
    {
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
            $dataResponse['expirationTime'] = (time() + $dataResponse['expires_in']) - 60;
        }else{
            $error = '';
            if(isset($dataResponse['error'])){
                $error = $dataResponse['error'];
                $error = (isset($dataResponse['detailedmessage'])) ? $error." ".$dataResponse['detailedmessage'] : $error;
            }
            throw new \yii\web\BadRequestHttpException($error);
        }

        return $dataResponse;
    }

    private function handleError($errorMessage)
    {
        $transportError = 'Curl error: #';//yiisoft\yii2-httpclient\src\CurlTransport.php
        switch (true){
            case stristr($errorMessage,$transportError.CURLE_OPERATION_TIMEDOUT):
                $humanized = 'Communication Error';
               break;
            default:
                $humanized = 'Internal Error';
         }

         return $humanized;
    }
}