<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vitals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vitals-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Vitals', ['create', 'encounterId' => $encounterId], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'posting',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
