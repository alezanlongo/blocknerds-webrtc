<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clinical Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clinical-document-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Clinical Document', [
            'create',
            'patientid'     => $patientid,
            'departmentid'  => $departmentid
        ], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'class' => 'table table-striped table-bordered bg-light'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'actionnote',
            'assignedto',
            'clinicaldocumentid',
            'clinicalproviderid',
            'createddate',
            //'createddatetime',
            //'createduser',
            //'departmentid',
            //'documentclass',
            //'documentdata',
            //'documentdescription',
            //'documentroute',
            //'documentsource',
            //'documentsubclass',
            //'documenttypeid',
            //'externalnote',
            //'internalnote',
            //'lastmodifieddate',
            //'lastmodifieddatetime',
            //'lastmodifieduser',
            //'observationdate',
            //'ordertype',
            //'priority',
            //'providerid',
            //'providerusername',
            //'status',
            //'tietoorderid',
            //'externalId',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
