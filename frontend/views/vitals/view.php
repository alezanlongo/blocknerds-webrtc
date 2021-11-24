<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Athena\helpers\VitalsHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Vitals */

//$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vitals', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vitals-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
    <?php
    foreach($vitalsConfiguration as $vitalsReference){ ?>
        <?= VitalsHelper::render($vitalsReference, $vitaltsByClinicalId); ?>
    <?php } ?>

    <?php ActiveForm::end(); ?>
</div>
