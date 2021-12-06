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

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-striped table-bordered bg-light'
        ],
        'attributes' => [
            'id',
            'externalId',
            'class',
            'classdescription',
            'dateordered',
            'departmentid',
            'description',
            'orderid',
            'ordertype',
            'ordertypeid',
            'status',
        ],
    ]) ?>

</div>
