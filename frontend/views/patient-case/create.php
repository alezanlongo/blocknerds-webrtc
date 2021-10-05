<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Create Patient Case';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create a new Patient Case:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'create-patient-case-form']); ?>

                <?= $form->field($model, 'departmentid')->textInput(['value' => $patient->departmentid, 'readonly' => true]) ?>

                <?= $form->field($model, 'subject')->textInput() ?>

                <?= $form->field($model, 'documentsource')->dropdownList(array_combine($documentsources, $documentsources),
                    ['prompt'=>'Select Document Source']
                );?>

                <?= $form->field($model, 'documentsubclass')->dropdownList(array_combine($documentsubclasses, $documentsubclasses),
                    ['prompt'=>'Select SubClass']
                );?>

                <?= $form->field($model, 'providerid')->dropdownList($providers,
                    ['prompt'=>'Select Provider']
                );?>

                <div class="form-group">
                    <?= Html::submitButton('Create Patient Case', ['class' => 'btn btn-primary', 'name' => 'create-patient-case-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
