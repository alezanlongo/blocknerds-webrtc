<?php

namespace common\components\Withings;

use Yii;
use yii\base\Model;


class WithingsClient extends \common\components\Withings\WithingsOauth 
{
    /**
     * @return inline_response_200
     */
    public function oauth2Getaccesstoken(array $body = [])
    {
        $path = trim('/v2/oauth2');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200
     */
    public function oauth2Refreshaccesstoken(array $body = [])
    {
        $path = trim('/v2/oauth2  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_1
     */
    public function oauth2Recoverauthorizationcode(array $body = [])
    {
        $path = trim('/v2/oauth2 ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_1Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_2
     */
    public function measureGetmeas(array $body = [])
    {
        $path = trim('/measure');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_2Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_3
     */
    public function notifyGet(array $body = [])
    {
        $path = trim('/notify ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_3Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_4
     */
    public function notifyList(array $body = [])
    {
        $path = trim('/notify  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_4Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_5
     */
    public function notifyRevoke(array $body = [])
    {
        $path = trim('/notify    ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_5Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_5
     */
    public function notifySubscribe(array $body = [])
    {
        $path = trim('/notify');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_5Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_5
     */
    public function notifyUpdate(array $body = [])
    {
        $path = trim('/notify   ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_5Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_6
     */
    public function dropshipmentv2Createorder(array $body = [])
    {
        $path = trim('/v2/dropshipment');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_6Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_7
     */
    public function dropshipmentv2Createuserorder(array $body = [])
    {
        $path = trim('/v2/dropshipment ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_7Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_5
     */
    public function dropshipmentv2Delete(array $body = [])
    {
        $path = trim('/v2/dropshipment   ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_5Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_8
     */
    public function dropshipmentv2Getorderstatus(array $body = [])
    {
        $path = trim('/v2/dropshipment  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_8Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_9
     */
    public function dropshipmentv2Update(array $body = [])
    {
        $path = trim('/v2/dropshipment    ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_9Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_10
     */
    public function heartv2Get(array $body = [])
    {
        $path = trim('/v2/heart ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_10Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_11
     */
    public function heartv2List(array $body = [])
    {
        $path = trim('/v2/heart');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_11Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_12
     */
    public function measurev2Getactivity(array $body = [])
    {
        $path = trim('/v2/measure');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_12Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_13
     */
    public function measurev2Getintradayactivity(array $body = [])
    {
        $path = trim('/v2/measure  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_13Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_14
     */
    public function measurev2Getworkouts(array $body = [])
    {
        $path = trim('/v2/measure ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_14Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_15
     */
    public function signaturev2Getnonce(array $body = [])
    {
        $path = trim('/v2/signature');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_15Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_16
     */
    public function sleepv2Get(array $body = [])
    {
        $path = trim('/v2/sleep');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_16Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_17
     */
    public function sleepv2Getsummary(array $body = [])
    {
        $path = trim('/v2/sleep ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_17Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_18
     */
    public function userv2Activate(array $body = [])
    {
        $path = trim('/v2/user ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_18Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_19
     */
    public function userv2Get(array $body = [])
    {
        $path = trim('/v2/user');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_19Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_20
     */
    public function userv2Getdevice(array $body = [])
    {
        $path = trim('/v2/user   ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_20Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_21
     */
    public function userv2Getgoals(array $body = [])
    {
        $path = trim('/v2/user     ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_21Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_22
     */
    public function userv2Link(array $body = [])
    {
        $path = trim('/v2/user  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_22Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return inline_response_200_5
     */
    public function userv2Unlink(array $body = [])
    {
        $path = trim('/v2/user    ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            return new \common\components\Withings\apiModels\inline_response_200_5Api($dataResponse[$this->getResponseDataKey()]);
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
}
