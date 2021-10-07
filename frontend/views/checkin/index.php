<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Checkins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="checkin-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Checkin', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'message',
            'success',
            'externalId',
            'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
