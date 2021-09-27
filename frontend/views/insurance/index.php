<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Insurances';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insurance-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Insurance', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'adjusterfax',
            'adjusterfirstname',
            'adjusterlastname',
            'adjusterphone',
            'anotherpartyresponsibleyn',
            //'autoaccidentstate',
            //'cancelled',
            //'caseinjurydate',
            //'casepolicytypename',
            //'ccmstatusid',
            //'ccmstatusname',
            //'coinsurancepercent',
            //'copays',
            //'descriptionofinjury',
            //'eligibilitylastchecked',
            //'eligibilitymessage',
            //'eligibilityreason',
            //'eligibilitystatus',
            //'employerid',
            //'expirationdate',
            //'icd10codes',
            //'icd9codes',
            //'injuredbodypart',
            //'insuranceclaimnumber',
            //'insuranceid',
            //'insuranceidnumber',
            //'insurancepackageaddress1',
            //'insurancepackageaddress2',
            //'insurancepackagecity',
            //'insurancepackageid',
            //'insurancepackagestate',
            //'insurancepackagezip',
            //'insurancephone',
            //'insuranceplandisplayname',
            //'insuranceplanname',
            //'insurancepolicyholder',
            //'insurancepolicyholderaddress1',
            //'insurancepolicyholderaddress2',
            //'insurancepolicyholdercity',
            //'insurancepolicyholdercountrycode',
            //'insurancepolicyholdercountryiso3166',
            //'insurancepolicyholderdob',
            //'insurancepolicyholderfirstname',
            //'insurancepolicyholderlastname',
            //'insurancepolicyholdermiddlename',
            //'insurancepolicyholdersex',
            //'insurancepolicyholderssn',
            //'insurancepolicyholderstate',
            //'insurancepolicyholdersuffix',
            //'insurancepolicyholderzip',
            //'insurancetype',
            //'insuredentitytypeid',
            //'insuredpcp',
            //'insuredpcpnpi',
            //'ircid',
            //'ircname',
            //'issuedate',
            //'policynumber',
            //'relatedtoautoaccidentyn',
            //'relatedtoemploymentyn',
            //'relatedtootheraccidentyn',
            //'relationshiptoinsured',
            //'relationshiptoinsuredid',
            //'repricername',
            //'repricerphone',
            //'sequencenumber',
            //'slidingfeeplanid',
            //'stateofreportedinjury',
            //'externalId',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
