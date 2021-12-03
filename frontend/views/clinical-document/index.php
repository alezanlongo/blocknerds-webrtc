<?php

use yii\helpers\Url;
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
            'departmentid'  => $departmentid,
            'type'          => $type
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
            [
                'attribute' => 'Document',
                'value' => function ($model){
                    $url = Url::toRoute([
                        'view',
                        'id'        => $model->id,
                        'patientid' => $model->patientid,

                    ]);
                    return Html::a(
                        'Documnent',
                        $url,
                        ['title' => 'Documnent',],
                    );
                },
                'format' => 'raw',
            ],
            //['class'     => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
