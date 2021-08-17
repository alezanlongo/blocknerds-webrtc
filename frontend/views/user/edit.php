<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<h1>Edit Profile</h1>
<hr class="border-bottom border-white">


<div class="box-profile">
    <?php $form = ActiveForm::begin(['id' => 'edit-profile-form']); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'confirm_password')->passwordInput() ?>

    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>
</div>