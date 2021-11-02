<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Patient */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Patients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="patient-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Insurance', ['patient-insurance/create-insurance', 'patientId' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Create Appointment', ['appointment/create', 'patientid' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Create Patient Case', ['patient-case/create', 'patientid' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Create Chart Alert', ['patient-insurance/create-chart-alert', 'patientId' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php if ($chartAlert->notetext): ?>
        <div class="alert alert-danger" role="alert">
            Chart Alert: <?= $chartAlert->notetext ?>
        </div>
    <?php endif ?>

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-striped table-bordered detail-view bg-light'
            ],
        'attributes' => [
            'id',
            'externalId',
            'departmentid',
            'dob',
            'email:email',
            'firstname',
            'lastname',
            'primarydepartmentid',
            'registrationdate',
            'status',
        ],
    ]) ?>

</div>
