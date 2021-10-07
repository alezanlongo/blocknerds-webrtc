<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Checkin */

$this->title = 'Create Checkin';
$this->params['breadcrumbs'][] = ['label' => 'Checkins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="checkin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
