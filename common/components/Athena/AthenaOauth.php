<?php
namespace common\components\Athena;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\httpclient\Client;


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

        try {
            if(is_null($session->get('athenaAuth'))){
                $link = Yii::$app->params['athena_url'].self::URL_SERVICE_AUTH;
                $client = new Client();
                $response = $client->createRequest()
                    ->setMethod('POST')
                    ->setUrl($link)
                    ->setHeaders([
                        'Content-type' => 'application/x-www-form-urlencoded',
                        'Authorization' => 'Basic ' . base64_encode(Yii::$app->params['athena_key'] . ':' . Yii::$app->params['athena_secret']),
                    ])
                    ->setData([
                        'grant_type'    => 'client_credentials',
                        'scope'         => 'athena/service/Athenanet.MDP.*',
                    ])
                    ->send();

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
                    if(isset($dataResponse['error'])){
                        $data = [
                            'message'       => $dataResponse['error']." ".$dataResponse['detailedmessage'],
                            'data'          => [],
                            'success'       => $success,
                            'statusCode'    => $dataStatusCodeRespose
                        ];
                    }else{
                        $data = [
                            'message'       => "",
                            'data'          => [],
                            'success'       => $success,
                            'statusCode'    => $dataStatusCodeRespose
                        ];
                    }
                }
            }else{
                $data = $session->get('athenaAuth');
            }
        }catch(\Exception $e){
            $data = [
                'message'       => $e->getMessage(),
                'data'          => [],
                'success'       => $success,
                'statusCode'    => 0
            ];
        }

        return $data;
    }


    public function callMethod($path, $action, array $params = [])
    {
        $data = [];
        $success =  FALSE;
        $session = Yii::$app->session;
        try {
            $dataSession = $dataSession = $this->Authenticate();
            if($dataSession['success']){
                $interval = time() - strtotime($dataSession['data']['created_time']);
                if((int)$interval < (int)$dataSession['data']['expires_in']){
                    $session->remove('athenaAuth');
                    $dataSession = $this->Authenticate();
                }

                if(isset($dataSession['data']['access_token'])){
                    $link = Yii::$app->params['athena_url'].$path;
                    $client = new Client();

                    if(count($params) > 0){
                        $response = $client->createRequest()
                            ->setMethod($action)
                            ->setUrl($link)
                            ->setHeaders([
                                'Authorization' => 'Bearer ' . $dataSession['data']['access_token'],
                            ])
                            ->setData($params)
                            ->send();
                    }else{
                        $response = $client->createRequest()
                            ->setMethod($action)
                            ->setUrl($link)
                            ->setHeaders([
                                'Authorization' => 'Bearer ' . $dataSession['data']['access_token'],
                            ])
                            ->send();
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
                        if(isset($dataResponse['error'])){
                            $data = [
                                'message'       => $dataResponse['error']." ".$dataResponse['detailedmessage'],
                                'data'          => [],
                                'success'       => $success,
                                'statusCode'    => $dataStatusCodeRespose
                            ];
                        }else{
                            $data = [
                                'message'       => "",
                                'data'          => [],
                                'success'       => $success,
                                'statusCode'    => $dataStatusCodeRespose
                            ];
                        }
                    }
                }else{
                    $data = $dataSession;
                }
            }else{
                $data = $dataSession;
            }
        }catch(\Exception $e){
            $data = [
                'message'       => $e->getMessage(),
                'data'          => [],
                'success'       => $success,
                'statusCode'    => 0
            ];
        }

        return $data;
    }
}