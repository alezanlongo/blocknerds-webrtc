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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'class' => 'table table-striped table-bordered bg-light'
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'adjusterfax',
            // 'adjusterfirstname',
            // 'adjusterlastname',
            // 'adjusterphone',
            // 'anotherpartyresponsibleyn',
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
            'insuranceid',
            'insuranceidnumber',
            //'insurancepackageaddress1',
            //'insurancepackageaddress2',
            // 'insurancepackagecity',
            //'insurancepackageid',
            //'insurancepackagestate',
            //'insurancepackagezip',
            //'insurancephone',
            //'insuranceplandisplayname',
            'insuranceplanname',
            //'insurancepolicyholder',
            //'insurancepolicyholderaddress1',
            //'insurancepolicyholderaddress2',
            //'insurancepolicyholdercity',
            //'insurancepolicyholdercountrycode',
            //'insurancepolicyholdercountryiso3166',
            //'insurancepolicyholderdob',
            'insurancepolicyholderfirstname',
            'insurancepolicyholderlastname',
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

            [
             'class' => 'yii\grid\ActionColumn',
             'template' => '{view-insurance}',
             'buttons' => [
                'view-insurance' => function ($url) {
                    return Html::a(
                        '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z"/></svg>',
                        [$url],
                    );
                },
             ],
            ]
        ],
    ]); ?>


</div>
