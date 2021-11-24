<?php

use yii\helpers\Html;
use common\components\Athena\helpers\VitalsHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Vitals */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vitals-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    foreach($vitalsConfiguration as $vitalsReference){ ?>
        <?= VitalsHelper::render($vitalsReference); ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>



    <?php ActiveForm::end(); ?>

</div>