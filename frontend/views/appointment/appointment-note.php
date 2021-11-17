<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Add Appointment Note';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to add an Appointment Note:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'add-appointment-note-form']); ?>

                <?= $form->field($model, 'notetext')->textInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Add Appointment Note', ['class' => 'btn btn-primary', 'name' => 'add-appointment-note-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
