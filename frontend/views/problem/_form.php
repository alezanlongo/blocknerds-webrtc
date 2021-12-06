<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Encounter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="problem-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PATIENTFACINGCALL')->radioList(['0' => 'False', '1' => 'True']) ?>
    <?= $form->field($model, 'THIRDPARTYUSERNAME')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'departmentid')->dropdownList($departments,
        ['prompt'=>'Select Category']
    ); ?>
    <?= $form->field($model, 'laterality')->dropdownList($laterality,
        ['prompt'=>'Select Laterality']
    ); ?>
    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'snomedcode')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'startdate')->textInput(['maxlength' => true]) /* FIXME use date picker*/ ?>
    <?= $form->field($model, 'status')->dropdownList($status,
        ['prompt'=>'Select Status']
    ); ?>

    <?php echo Html::hiddenInput('patient_id' , $patient->id, ['id' => 'patient_id']); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
