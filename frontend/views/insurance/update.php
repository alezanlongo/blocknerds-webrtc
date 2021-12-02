<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Insurance */

$this->title = 'Update Insurance: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Insurances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="insurance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'insurancepackageid')->dropDownList($insurancePackages
        ,['options' => [($model->insurancepackageid == 0) ? 0 : $model->insurancepackageid => ['Selected'=>'selected']]
            , 'prompt' => ' Select Insurance Plan', 'disabled' => true]); ?>

    <?= $form->field($model, 'insuranceidnumber')->textInput(['maxlength' => true])->label('Insurance ID Number'); ?>

    <?= $form->field($model, 'insurancepolicyholderfirstname')->textInput(['maxlength' => true])->label('Policy holder first name');  ?>

    <?= $form->field($model, 'insurancepolicyholderlastname')->textInput(['maxlength' => true])->label('Policy holder last name'); ?>

    <?= $form->field($model, 'insurancepolicyholdersex')->radioList(array('M'=>'Male','F'=>'Female'))->label('Policy holder sex');; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
