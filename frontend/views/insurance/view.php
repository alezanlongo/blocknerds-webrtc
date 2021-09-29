<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Insurance */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Insurances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="insurance-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-striped table-bordered detail-view bg-light'
        ],
        'attributes' => [
            'adjusterfax',
            'adjusterfirstname',
            'adjusterlastname',
            'adjusterphone',
            'anotherpartyresponsibleyn',
            'autoaccidentstate',
            'cancelled',
            'caseinjurydate',
            'casepolicytypename',
            'ccmstatusid',
            'ccmstatusname',
            'coinsurancepercent',
            'copays',
            'descriptionofinjury',
            'eligibilitylastchecked',
            'eligibilitymessage',
            'eligibilityreason',
            'eligibilitystatus',
            'employerid',
            'expirationdate',
            'icd10codes',
            'icd9codes',
            'injuredbodypart',
            'insuranceclaimnumber',
            'insuranceid',
            'insuranceidnumber',
            'insurancepackageaddress1',
            'insurancepackageaddress2',
            'insurancepackagecity',
            'insurancepackageid',
            'insurancepackagestate',
            'insurancepackagezip',
            'insurancephone',
            'insuranceplandisplayname',
            'insuranceplanname',
            'insurancepolicyholder',
            'insurancepolicyholderaddress1',
            'insurancepolicyholderaddress2',
            'insurancepolicyholdercity',
            'insurancepolicyholdercountrycode',
            'insurancepolicyholdercountryiso3166',
            'insurancepolicyholderdob',
            'insurancepolicyholderfirstname',
            'insurancepolicyholderlastname',
            'insurancepolicyholdermiddlename',
            'insurancepolicyholdersex',
            'insurancepolicyholderssn',
            'insurancepolicyholderstate',
            'insurancepolicyholdersuffix',
            'insurancepolicyholderzip',
            'insurancetype',
            'insuredentitytypeid',
            'insuredpcp',
            'insuredpcpnpi',
            'ircid',
            'ircname',
            'issuedate',
            'policynumber',
            'relatedtoautoaccidentyn',
            'relatedtoemploymentyn',
            'relatedtootheraccidentyn',
            'relationshiptoinsured',
            'relationshiptoinsuredid',
            'repricername',
            'repricerphone',
            'sequencenumber',
            'slidingfeeplanid',
            'stateofreportedinjury',
            'externalId',
            'id',
        ],
    ]) ?>

</div>
