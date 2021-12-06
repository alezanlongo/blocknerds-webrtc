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
        <?php if(count($insuraceCardImage) > 0): ?>
            <?= Html::a('Upload Card', [
                'insurance-card-image/create',
                'patientid'             => $patientid,
                'departmentid'          => $departmentid,
                'insuranceid'           => $model->insuranceid,
                'patientInsurance_id'   => $model->id,
            ], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('View Card', [
                'insurance-card-image/view',
                'id'            => $model->insuranceid,
                'patientid'     => $patientid,
            ], ['class' => 'btn btn-warning']) ?>
        <?php else: ?>
            <?= Html::a('Create Card', [
                'insurance-card-image/create',
                'patientid'             => $patientid,
                'departmentid'          => $departmentid,
                'insuranceid'           => $model->insuranceid,
                'patientInsurance_id'   => $model->id,
            ], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-striped table-bordered detail-view bg-light'
        ],
        'attributes' => [
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
