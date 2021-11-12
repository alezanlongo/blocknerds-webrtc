<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Create Medication';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create a new Medication:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'create-medication-form']); ?>

                <?= $form->field($model, 'departmentid')->textInput(['value' => $patient->departmentid, 'readonly' => true]) ?>

                <?= $form->field($model, 'medicationid')->textInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Create Medication', ['class' => 'btn btn-primary', 'name' => 'create-medication-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
