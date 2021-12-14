<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Privacy Information';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-4 form-group form-check">
            <label class="form-check-label">Patient Signature</label><?= Html::input('checkbox', 'patientsignature',
                $pricavyInformation->patientsignature['ispatientsignatureonfile'], [
                'class' => "form-check-input",
                'id'    => 'patientsignature'
            ]); ?>
        </div>
        <div class="col-4 form-group form-check">
            <label class="form-check-label">Privacy Notice</label><?= Html::input('checkbox', 'privacynotice',
                $pricavyInformation->privacynotice['isprivacynoticeonfile'], [
                'class' => "form-check-input",
                'id'    => 'privacynotice'
            ]); ?>
        </div>
        <div class="col-4 form-group form-check">
            <label class="form-check-label">Insured Signature</label><?= Html::input('checkbox', 'insuredsignature',
                $pricavyInformation->insuredsignature['isinsuredsignatureonfile'], [
                'class' => "form-check-input",
                'id'    => 'insuredsignature'
            ]); ?>
        </div>
    </div>
    <div class="row">
        <?= Html::hiddenInput("departmentid", $departmentid, [
            'id'    => 'departmentid'
        ]) ?>
        <?= Html::hiddenInput("patientid", $patientid, [
            'id'    => 'patientid'
        ]) ?>
        <?= Html::hiddenInput("url-post", Url::toRoute(['privacy-information-verified/create']), [
            'id'    => 'url-post'
        ]) ?>
    </div>
</div>

<?php $this->registerJsFile(
    '@web/js/Athena/privacy-information.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
); ?>
