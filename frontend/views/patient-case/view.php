<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\PatientCase */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Patient Cases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="patient-cases-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update Patient Case', ['patient-case/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reassign Patient Case', ['patient-case/reassign', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Close Patient Case', ['patient-case/close', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add Action Note', ['patient-case/add-action-note', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-striped table-bordered detail-view bg-light'
            ],
        'attributes' => [
            'id',
            'externalId',
            'subject',
            'departmentid',
            'documentclass',
            'documentsource',
            'patientid',
            'providerid',
            'assignedto',
            'actionnote',
            'createddate',
            'status',
        ],
    ]) ?>

</div>
