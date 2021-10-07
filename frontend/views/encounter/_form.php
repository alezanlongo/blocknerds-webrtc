<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Encounter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="encounter-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php /*$form->field($model, 'appointmentid')->textInput()
    $form->field($model, 'closeddate')->textInput(['maxlength' => true])
    $form->field($model, 'closeduser')->textInput(['maxlength' => true])
    $form->field($model, 'departmentid')->textInput()
    $form->field($model, 'encounterdate')->textInput(['maxlength' => true])
    $form->field($model, 'encounterid')->textInput()
    $form->field($model, 'encountertype')->textInput(['maxlength' => true])
    $form->field($model, 'encountervisitname')->textInput(['maxlength' => true])
    $form->field($model, 'lastreopened')->textInput(['maxlength' => true])
    $form->field($model, 'lastupdated')->textInput(['maxlength' => true])*/ ?>

    <?= $form->field($model, 'patientlocation')->hiddenInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patientlocationid')->dropdownList($patientLocations,
        ['prompt'=>'Select a Patient Location']
    );?>

    <?= $form->field($model, 'patientstatus')->hiddenInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patientstatusid')->dropdownList($patientStatuses,
        ['prompt'=>'Select a Patient Status']
    );?>

    <?php /*$form->field($model, 'providerfirstname')->textInput(['maxlength' => true])
    $form->field($model, 'providerid')->textInput()
    $form->field($model, 'stage')->textInput(['maxlength' => true])
    $form->field($model, 'status')->textInput(['maxlength' => true])
    $form->field($model, 'externalId')->textInput(['maxlength' => true])
    $form->field($model, 'id')->textInput()*/ ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
