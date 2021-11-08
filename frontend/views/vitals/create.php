<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Vitals */

$this->title = 'Create Vitals';
$this->params['breadcrumbs'][] = ['label' => 'Vitals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vitals-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'vitalsConfiguration' => $vitalsConfiguration
    ]) ?>

</div>
