<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Problem */

$this->title = 'Viewing Problem: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Problems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="problem-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <? /*= Html::a('Update', [
            'update',
            'id'            => $model->id,
            //'departmentId'  => $model->departmentid
        ], ['class' => 'btn btn-primary']) */ ?>

        <?= Html::a('Problems', ['index', 'patientid' => $model->patient_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-striped table-bordered detail-view bg-light'
            ],
        'attributes' => [
            'id',
            'externalId',
            'bestmatchicd10code',
            'code',
            'codeset',
            'mostrecentdiagnosisnote',
            'name',
        ],
    ]) ?>

</div>
