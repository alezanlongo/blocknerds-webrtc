<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Update Patient Case';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create a new Patient Case:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'create-patient-case-form']); ?>


                <?= $form->field($model, 'subject')->textInput(['value' => $patientCase->subject ]) ?>

                <?= $form->field($model, 'documentsource')->dropdownList(array_combine($documentsources, $documentsources),
                    ['prompt'=>'Select Document Source', 'options'=>[
                        "$patientCase->documentsource"=>['Selected'=>true]]]
                );?>

                <?= $form->field($model, 'documentsubclass')->dropdownList(array_combine($documentsubclasses, $documentsubclasses),
                    ['prompt'=>'Select SubClass', 'options'=>[
                        "$patientCase->documentclass"=>['Selected'=>true]]]
                );?>

                <?= $form->field($model, 'providerid')->dropdownList($providers,
                    ['prompt'=>'Select Provider','options'=>[
                        "$patientCase->providerid"=>['Selected'=>true]]]
                );?>

                <div class="form-group">
                    <?= Html::submitButton('Update Patient Case', ['class' => 'btn btn-primary', 'name' => 'update-patient-case-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
