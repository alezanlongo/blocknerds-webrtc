<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Encounters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="encounter-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'class' => 'table table-striped table-bordered bg-light'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'appointmentid',
            //'closeddate',
            //'closeduser',
            'departmentid',
            //'diagnoses',
            //'encounterdate',
            'encounterid',
            //'encountertype',
            //'encountervisitname',
            //'lastreopened',
            //'lastupdated',
            //'patientlocation',
            //'patientlocationid',
            //'patientstatus',
            //'patientstatusid',
            'providerfirstname',
            //'providerid',
            //'providerlastname',
            //'providerphone',
            'stage',
            'status',
            //'externalId',
            //'id',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ]
        ],
    ]); ?>


</div>
