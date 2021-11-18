<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Photo */

$this->title = 'Create Photo';
$this->params['breadcrumbs'][] = ['label' => 'Photos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
