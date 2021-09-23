<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Department */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="department-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chartsharinggroupid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'clinicalproviderfax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'clinicals')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'communicatorbrandid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'creditcardtypes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'departmentid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doesnotobservedst')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ecommercecreditcardtypes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ishospitaldepartment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'latitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'longitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'medicationhistoryconsent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oneyearcontractmax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patientdepartmentname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placeofservicefacility')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placeofservicetypeid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placeofservicetypename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'portalurl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'providergroupid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'providergroupname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'providerlist')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'servicedepartment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'singleappointmentcontractmax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'timezone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'timezonename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'timezoneoffset')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
