<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Diagnosis */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Diagnosis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="diagnosis-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', [
            'update-diagnosis',
            'id'            => $model->id,
        ], ['class' => 'btn btn-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-striped table-bordered bg-light'
        ],
        'attributes' => [
            'id',
            'externalId',
            'snomedcode',
            'description',
            'supportslaterality',
            'ranking',
        ],
    ]) ?>

</div>
