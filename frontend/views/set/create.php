<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Set */

$this->title = 'Create Set';
$this->params['breadcrumbs'][] = ['label' => 'Sets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="set-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
