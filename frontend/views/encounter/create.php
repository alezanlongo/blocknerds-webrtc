<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Encounter */

$this->title = 'Create Encounter';
$this->params['breadcrumbs'][] = ['label' => 'Encounters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="encounter-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'             => $model,
        'patientLocations'  => $patientLocations,
        'patientStatuses'   => $patientStatuses,
    ]) ?>

</div>
