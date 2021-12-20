<?php
namespace common\components\Snomed;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\Exception as DBException;
use yii\httpclient\Client;
use yii\httpclient\Exception as HttpClientException;

use common\models\Configuration;

class Snomed
{
    private const BASE_URL  = 'https://browser.ihtsdotools.org/snowstorm/snomed-ct/';
    private const EDITION  = 'MAIN';
    private const VERSION = '2019-07-31';


    public function callMethod($path, $action, array $params = [])
    {
        $data = [];
        $success =  FALSE;

        $link = self::BASE_URL . self::EDITION . '/' . self::VERSION . '/'.$path;

        $client = new Client([
            'transport' => 'yii\httpclient\CurlTransport'
        ]);
        $request = $client->createRequest();

        $request->setMethod($action)
            ->setUrl($link);
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


    public function getConceptByString($searchTerm)
    {
        $path = 'concepts';

        $body = [
            'term' => $searchTerm,
            'activeFilter' => true,
            'offset' => 0,
            'limit' => 50
        ];

        $dataResponse = $this->callMethod($path, 'get' , $body);

        return $dataResponse['data'];
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