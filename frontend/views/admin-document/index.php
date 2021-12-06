<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-document-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Admin Document', [
            'create',
            'patientid'     => $patientid,
            'departmentid'  => $departmentid,
            'type'          => $type
        ], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'actionnote',
            'adminid',
            'appointmentid',
            'assignedto',
            'clinicalproviderid',
            //'createddate',
            //'createddatetime',
            //'createduser',
            //'deleteddatetime',
            //'departmentid',
            //'description',
            //'documentclass',
            //'documentdata',
            //'documentdate',
            //'documentroute',
            //'documentsource',
            //'documentsubclass',
            //'documenttypeid',
            //'encounterid',
            //'entitytype',
            //'externalaccessionid',
            //'externalnote',
            //'internalaccessionid',
            //'internalnote',
            //'lastmodifieddate',
            //'lastmodifieddatetime',
            //'lastmodifieduser',
            //'originaldocument',
            //'priority',
            //'providerid',
            //'providerusername',
            //'status',
            //'subject',
            //'tietoorderid',
            //'externalId',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
