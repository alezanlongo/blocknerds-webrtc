<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Medical Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medical-history-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Medical History', [
            'create',
            'patientid' => $patientid
        ], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Create Medical History', [
            'create',
            'patientid' => $patientid
        ], ['class' => 'btn btn-warning']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sectionnote',
            'externalId',
            'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
