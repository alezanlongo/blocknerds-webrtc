<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Create Patient';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create a new Patient:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'create-patient-form']); ?>

                <?= $form->field($model, 'firstname')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'lastname')->textInput() ?>

                <?= $form->field($model, 'dob')->textInput() ?>

                <?= $form->field($model, 'departmentid')->dropdownList($departments,
                    ['prompt'=>'Select Category']
                );?>

                <?= $form->field($model, 'email')->textInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Create Patient', ['class' => 'btn btn-primary', 'name' => 'create-patient-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
