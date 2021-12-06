<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Close Patient Case';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to close a Patient Case:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'create-patient-case-form']); ?>

                <?= $form->field($model, 'actionreasonid')->dropdownList($closeReasons,
                    ['prompt'=>'Select a reason']
                );?>

                <div class="form-group">
                    <?= Html::submitButton('Close Patient Case', ['class' => 'btn btn-primary', 'name' => 'create-patient-case-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
