<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Problem */

$this->title = 'Update Problem: ' . $problem->id;
$this->params['breadcrumbs'][] = ['label' => 'Problems', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $problem->id, 'url' => ['view', 'id' => $problem->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="problem-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'             => $model,
        'departments'       => $departments,
        'patient'           => $problem->patient,
        'laterality'        => $laterality,
        'status'            => $status,
    ]) ?>

</div>

<?php /*
$this->registerJsFile(
    '@web/js/Athena/encounter.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
*/ ?>
