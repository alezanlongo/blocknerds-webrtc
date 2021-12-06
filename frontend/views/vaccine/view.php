<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Vaccine */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vaccines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vaccine-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-striped table-bordered detail-view bg-light'
            ],
        'attributes' => [
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
        ],
    ]) ?>

</div>
