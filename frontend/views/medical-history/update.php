<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\MedicalHistory */

$this->title = 'Update Medical History: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Medical Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="medical-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'                     => $model,
        'questions'                 => $questions,
        'medicalHistoryQuestions'   => $medicalHistoryQuestions
    ]) ?>

</div>
