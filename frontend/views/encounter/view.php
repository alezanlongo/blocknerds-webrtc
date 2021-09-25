<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Encounter */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Encounters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="encounter-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', [
            'update',
            'id'            => $model->id,
            'departmentId'  => $model->departmentid
        ], ['class' => 'btn btn-primary']) ?>
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
            'class' => 'table table-striped table-bordered bg-light'
        ],
        'attributes' => [
            'appointmentid',
            'closeddate',
            'closeduser',
            'departmentid',
            'diagnoses',
            'encounterdate',
            'encounterid',
            'encountertype',
            'encountervisitname',
            'lastreopened',
            'lastupdated',
            'patientlocation',
            'patientlocationid',
            'patientstatus',
            'patientstatusid',
            'providerfirstname',
            'providerid',
            'providerlastname',
            'providerphone',
            'stage',
            'status',
            'externalId',
            'id',
        ],
    ]) ?>

</div>
