<?php

use frontend\assets\users\UserProfileAsset;
use yii\helpers\BaseUrl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->registerAssetBundle(UserProfileAsset::class);

?>

<h1>Edit Profile</h1>
<hr class="border-bottom border-white">

<div class="box-profile">
    <?php $form = ActiveForm::begin(['id' => 'edit-profile-form', 'options' => ['class' => 'd-flex justify-content-center']]); ?>
    <div class="content-img">
        <?php if ($model->image) { ?>
            <img src="<?= Url::home() . $model->image ?>" alt="img-profile" width="200px" height="200px" class="profile-image rounded-circle">
        <?php } else { ?>
            <i class="fa fa-user-circle icon-profile profile-image" aria-hidden="true"></i>
            <img src="" alt="img-profile" width="200px" height="200px" class="profile-image rounded-circle d-none">
        <?php } ?>
        <?= $form->field($model, 'image')->fileInput(['class' => 'd-none input-image-profile'])->label(false) ?>
    </div>
    <div class="content-form">
        <!-- <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => "Username", 'readOnly'=>true]) ?> -->
        <!-- <?= $form->field($model, 'email')->textInput()->input('email', ['placeholder' => "Email"]) ?> -->
        <?= $form->field($model, 'first_name')->textInput(['placeholder' => "First name"]) ?>
        <?= $form->field($model, 'last_name')->textInput(['placeholder' => "Last name"]) ?>
        <?= $form->field($model, 'phone')->textInput(['placeholder' => "Phone"]) ?>
        
        <?= $form->field($model, 'timezone')->dropDownList( $timezoneOptions, ['value' => array_search($model->timezone, $timezoneOptions)]); ?> <!-- , ["value"=> 424] -->
        <?= $form->field($model, 'locale')->dropDownList($localeOptions, ['value' => array_search($model->locale, $localeOptions)]); ?>
        <!-- <?= $form->field($model, 'password')->passwordInput(['placeholder' => "Password"]) ?>
        <?= $form->field($model, 'confirm_password')->passwordInput(['placeholder' => "Confirm Password"]) ?> -->

        <div class="float-right mt-3">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
</div>