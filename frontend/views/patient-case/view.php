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
            'priority',
            'createddate',
            'status',
        ],
    ]) ?>

</div>