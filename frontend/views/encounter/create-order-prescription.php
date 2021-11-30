<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Create Order (Prescription)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create a new Order (Prescription):</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'create-order-prescription-form']); ?>

                <?= $form->field($model, 'diagnosissnomedcode')->textInput() ?>

                <?= $form->field($model, 'ordertypeid')->textInput() ?>

                <?= $form->field($model, 'ndc')->textInput() ?>

                <?= $form->field($model, 'rxnormid')->textInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Create Order (Prescription)', ['class' => 'btn btn-primary', 'name' => 'create-order-prescription-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
