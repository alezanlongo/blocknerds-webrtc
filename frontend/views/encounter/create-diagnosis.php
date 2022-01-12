<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use frontend\widgets\snomedAutocomplete\SnomedAutocomplete;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Create Diagnosis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create a new Diagnosis:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'create-diagnosis-form']); ?>

                <?= SnomedAutocomplete::widget([
                        'name' => 'snomedcode',
                        'form' => $form,
                        'model' => $model,
                    ]
                ); ?>

                <div class="form-group">
                    <?= Html::submitButton('Create Diagnosis', ['class' => 'btn btn-primary', 'name' => 'create-diagnosis-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
