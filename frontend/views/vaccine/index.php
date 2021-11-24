<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vaccines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vaccine-index">

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
            'cvx',
            'mvx',
            'vaccinetype',
            'description',
            'entereddate',
            'genusname',
            'administerdate',
            'status',
            [
             'class' => 'yii\grid\ActionColumn',
             'template' => '{view}',
            ]
         ],
    ]); ?>


</div>
