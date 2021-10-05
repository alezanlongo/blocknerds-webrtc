<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Encounter */

$this->title = 'Update Encounter: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Encounters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="encounter-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'             => $model,
        'patientLocations'  => $patientLocations,
        'patientStatuses'   => $patientStatuses,
    ]) ?>

</div>

<?php
$this->registerJsFile(
    '@web/js/Athena/encounter.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
?>