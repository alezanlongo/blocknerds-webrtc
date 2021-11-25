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
            'id',
            'externalId',
            'snomedcode',
            'description',
            'ranking',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ]
        ],
    ]); ?>


</div>
