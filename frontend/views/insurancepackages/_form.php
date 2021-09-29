<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\insurancePackages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="insurance-packages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'insuranceplanname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'externalId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
