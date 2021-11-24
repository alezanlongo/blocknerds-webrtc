<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\JsExpression;

$this->title = 'Update Medication';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to update an existing Medication:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'update-medication-form']); ?>

                <?= $form->field($model, 'departmentid')->textInput(['value' => $medication->patient->departmentid, 'readonly' => true]) ?>

                <?= $form->field($model, 'providernote')->textInput(['value' => $medication->providernote]) ?>

                <?= $form->field($model, 'patientnote')->textInput(['value' => $medication->patientnote]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Update Medication', ['class' => 'btn btn-primary', 'name' => 'create-medication-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
