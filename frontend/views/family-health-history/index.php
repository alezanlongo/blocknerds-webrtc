<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Family Health Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="family-history-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'description',
            'diedofage',
            'note',
            'onsetage',
            'patientid',
            'problemid',
            'relation',
            //'relationkeyid',
            //'resolvedage',
            //'snomedcode',
            //'externalId',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
