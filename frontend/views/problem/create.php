<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Encounter */

$this->title = 'Create Problem';
$this->params['breadcrumbs'][] = ['label' => 'Problem', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="problem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'             => $model,
        'departments'       => $departments,
        'patient'           => $patient,
        'laterality'        => $laterality,
        'status'            => $status,
    ]) ?>

</div>
