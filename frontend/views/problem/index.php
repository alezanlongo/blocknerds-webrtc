<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Problems';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="problem-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'class' => 'table table-striped table-bordered bg-light'
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'externalId',
            'bestmatchicd10code',
            'code',
            'codeset',
            'mostrecentdiagnosisnote',
            'name',
            [
             'class' => 'yii\grid\ActionColumn',
             'template' => '{view}',
            ]
         ],
    ]); ?>


</div>
