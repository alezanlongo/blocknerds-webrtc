<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\MedicalHistory */

$this->title = 'Create Medical History';
$this->params['breadcrumbs'][] = ['label' => 'Medical Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medical-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
