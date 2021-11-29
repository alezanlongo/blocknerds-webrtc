<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Insurance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="insurance-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'insurancepackageid')->dropDownList($insurancePackages, ['prompt' => ' Select Insurance Plan']); ?>

    <?= $form->field($model, 'insuranceidnumber')->textInput(['maxlength' => true])->label('Insurance ID Number'); ?>

    <?= $form->field($model, 'insurancepolicyholderfirstname')->textInput(['maxlength' => true])->label('Policy holder first name');  ?>

    <?= $form->field($model, 'insurancepolicyholderlastname')->textInput(['maxlength' => true])->label('Policy holder last name'); ?>

    <?= $form->field($model, 'insurancepolicyholdersex')->radioList(array('M'=>'Male','F'=>'Female'))->label('Policy holder sex');; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
