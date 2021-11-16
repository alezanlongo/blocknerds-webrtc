<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model \common\models\LoginForm */

use frontend\controllers\UnsplashController;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
$src = UnsplashController::getRandomImage();
?>


<div class="row w-100">
    <div class="col-7 border-end border-white vh-100 p-0">
        <?= Html::img($src, ['class'=> 'img-fluid w-100 h-100']) ?>
    </div>
    <div class="col-4 mx-auto">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Please fill out the following fields to login:</p>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div style="color:#999;margin:1em 0">
            If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
            <br>
            Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>