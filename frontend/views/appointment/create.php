<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Create Appointment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create a new Appointment:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'create-appointment-form']); ?>

                <?= $form->field($model, 'departmentid')->textInput(['value' => $patient->departmentid, 'readonly' => true]) ?>

                <?= $form->field($model, 'appointmenttime')->textInput() ?>

                <?= $form->field($model, 'appointmentdate')->textInput() ?>

                <?= $form->field($model, 'appointmenttypeid')->textInput(['value' => 62, 'readonly' => true]) ?>

                <?= $form->field($model, 'providerid')->dropdownList($providers,
                    ['prompt'=>'Select Provider']
                );?>

                <div class="form-group">
                    <?= Html::submitButton('Create Appointment', ['class' => 'btn btn-primary', 'name' => 'create-appointment-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
