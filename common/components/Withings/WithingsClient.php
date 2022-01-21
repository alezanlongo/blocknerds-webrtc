<?php

namespace common\components\Withings;

use Yii;
use yii\base\Model;


class WithingsClient extends \common\components\Withings\WithingsOauth 
{
    /**
     * @return emptyApi
     */
    public function oauth2Getaccesstoken(array $body = [])
    {
        $path = trim('/v2/oauth2');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['oauth2'])) ? $dataResponse[$this->getResponseDataKey()]['oauth2'] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\emptyApiApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return emptyApi
     */
    public function oauth2Refreshaccesstoken(array $body = [])
    {
        $path = trim('/v2/oauth2  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['oauth2  '])) ? $dataResponse[$this->getResponseDataKey()]['oauth2  '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\emptyApiApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return emptyApi
     */
    public function oauth2Recoverauthorizationcode(array $body = [])
    {
        $path = trim('/v2/oauth2 ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['oauth2 '])) ? $dataResponse[$this->getResponseDataKey()]['oauth2 '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\emptyApiApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return measuregrp_object
     */
    public function measureGetmeas(array $body = [])
    {
        $path = trim('/measure');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['measuregrps'])) ? $dataResponse[$this->getResponseDataKey()]['measuregrps'] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\measuregrp_objectApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return emptyApi
     */
    public function notifyGet(array $body = [])
    {
        $path = trim('/notify ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['notify '])) ? $dataResponse[$this->getResponseDataKey()]['notify '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\emptyApiApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return notify_object
     */
    public function notifyList(array $body = [])
    {
        $path = trim('/notify  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['profiles'])) ? $dataResponse[$this->getResponseDataKey()]['profiles'] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\notify_objectApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return emptyApi
     */
    public function notifyRevoke(array $body = [])
    {
        $path = trim('/notify    ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['notify    '])) ? $dataResponse[$this->getResponseDataKey()]['notify    '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\emptyApiApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return emptyApi
     */
    public function notifySubscribe(array $body = [])
    {
        $path = trim('/notify');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['notify'])) ? $dataResponse[$this->getResponseDataKey()]['notify'] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\emptyApiApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return emptyApi
     */
    public function notifyUpdate(array $body = [])
    {
        $path = trim('/notify   ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['notify   '])) ? $dataResponse[$this->getResponseDataKey()]['notify   '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\emptyApiApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return dropshipment_create_order_object
     */
    public function dropshipmentv2Createorder(array $body = [])
    {
        $path = trim('/v2/dropshipment');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['orders'])) ? $dataResponse[$this->getResponseDataKey()]['orders'] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\dropshipment_create_order_objectApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return dropshipment_createuserorder
     */
    public function dropshipmentv2Createuserorder(array $body = [])
    {
        $path = trim('/v2/dropshipment ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['dropshipment '])) ? $dataResponse[$this->getResponseDataKey()]['dropshipment '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\dropshipment_createuserorderApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return emptyApi
     */
    public function dropshipmentv2Delete(array $body = [])
    {
        $path = trim('/v2/dropshipment   ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['dropshipment   '])) ? $dataResponse[$this->getResponseDataKey()]['dropshipment   '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\emptyApiApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return dropshipment_getorderstatus
     */
    public function dropshipmentv2Getorderstatus(array $body = [])
    {
        $path = trim('/v2/dropshipment  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['dropshipment  '])) ? $dataResponse[$this->getResponseDataKey()]['dropshipment  '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\dropshipment_getorderstatusApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return dropshipment_update
     */
    public function dropshipmentv2Update(array $body = [])
    {
        $path = trim('/v2/dropshipment    ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['dropshipment    '])) ? $dataResponse[$this->getResponseDataKey()]['dropshipment    '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\dropshipment_updateApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return heart_get
     */
    public function heartv2Get(array $body = [])
    {
        $path = trim('/v2/heart ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['heart '])) ? $dataResponse[$this->getResponseDataKey()]['heart '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\heart_getApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return heart_measurement_object
     */
    public function heartv2List(array $body = [])
    {
        $path = trim('/v2/heart');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['series'])) ? $dataResponse[$this->getResponseDataKey()]['series'] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\heart_measurement_objectApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return activity_object
     */
    public function measurev2Getactivity(array $body = [])
    {
        $path = trim('/v2/measure');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['activities'])) ? $dataResponse[$this->getResponseDataKey()]['activities'] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\activity_objectApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return measure_getintradayactivity
     */
    public function measurev2Getintradayactivity(array $body = [])
    {
        $path = trim('/v2/measure  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['measure  '])) ? $dataResponse[$this->getResponseDataKey()]['measure  '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\measure_getintradayactivityApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return workout_object
     */
    public function measurev2Getworkouts(array $body = [])
    {
        $path = trim('/v2/measure ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['series'])) ? $dataResponse[$this->getResponseDataKey()]['series'] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\workout_objectApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return emptyApi
     */
    public function signaturev2Getnonce(array $body = [])
    {
        $path = trim('/v2/signature');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['signature'])) ? $dataResponse[$this->getResponseDataKey()]['signature'] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\emptyApiApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return sleep_get
     */
    public function sleepv2Get(array $body = [])
    {
        $path = trim('/v2/sleep');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['sleep'])) ? $dataResponse[$this->getResponseDataKey()]['sleep'] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\sleep_getApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return sleep_summary_object
     */
    public function sleepv2Getsummary(array $body = [])
    {
        $path = trim('/v2/sleep ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['series'])) ? $dataResponse[$this->getResponseDataKey()]['series'] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\sleep_summary_objectApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return user_activate
     */
    public function userv2Activate(array $body = [])
    {
        $path = trim('/v2/user ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['user '])) ? $dataResponse[$this->getResponseDataKey()]['user '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\user_activateApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return user_get
     */
    public function userv2Get(array $body = [])
    {
        $path = trim('/v2/user');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['user'])) ? $dataResponse[$this->getResponseDataKey()]['user'] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\user_getApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return user_getdevice
     */
    public function userv2Getdevice(array $body = [])
    {
        $path = trim('/v2/user   ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['user   '])) ? $dataResponse[$this->getResponseDataKey()]['user   '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\user_getdeviceApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return user_getgoals
     */
    public function userv2Getgoals(array $body = [])
    {
        $path = trim('/v2/user     ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['user     '])) ? $dataResponse[$this->getResponseDataKey()]['user     '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\user_getgoalsApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return user_link
     */
    public function userv2Link(array $body = [])
    {
        $path = trim('/v2/user  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['user  '])) ? $dataResponse[$this->getResponseDataKey()]['user  '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\user_linkApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
    /**
     * @return emptyApi
     */
    public function userv2Unlink(array $body = [])
    {
        $path = trim('/v2/user    ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($this->isSuccess($dataResponse)){
            $dataApiModel = [];
            $responseData = (isset($dataResponse[$this->getResponseDataKey()]['user    '])) ? $dataResponse[$this->getResponseDataKey()]['user    '] : $dataResponse[$this->getResponseDataKey()];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\Withings\apiModels\emptyApiApi($value));
            }
            return $dataApiModel;
        }else{
            return $dataResponse[$this->getResponseMessageKey()];
        }
    }
}
