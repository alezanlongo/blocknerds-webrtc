<?php

use frontend\assets\users\UserProfileAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerAssetBundle(UserProfileAsset::class);

?>

<h1>Edit Profile</h1>
<hr class="border-bottom border-white">

<div class="box-profile">
    <?php $form = ActiveForm::begin(['id' => 'edit-profile-form', 'options'=> ['class' => 'd-flex justify-content-center']]); ?>
    <div class="content-img">
        <i class="fa fa-user-circle icon-profile" aria-hidden="true"></i>
    </div>
    <div class="content-form">

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => "Username"]) ?>

        <?= $form->field($model, 'email')->textInput()->input('email', ['placeholder' => "Email"]) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => "Password"]) ?>

        <?= $form->field($model, 'confirm_password')->passwordInput(['placeholder' => "Confirm Password"]) ?>


        <div class="float-right mt-3">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
</div>