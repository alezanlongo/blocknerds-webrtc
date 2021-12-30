<?php

use common\models\UserProfile;
use frontend\assets\users\UserProfileAsset;
use yii\bootstrap4\Modal;
use yii\helpers\BaseUrl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

//$this->registerAssetBundle(UserProfileAsset::class);

?>

<h1>Edit Profile</h1>
<hr class="border-bottom border-white">

<div class="container">
    <?php $form = ActiveForm::begin(['id' => 'edit-profile-form', 'options' => ['class' => '']]); ?>
    <div class="row">
        <div class="col">
            <div class="content-img text-center ">
                <?php if ($model->image) { ?>
                    <img src="<?= Yii::$app->getUser()->getIdentity()->getUserProfile()->one()->getBase64Image() ?>" alt="img-profile" width="200px" height="200px" class="profile-image rounded-circle">
                <?php } else { ?>
                    <i class="fa fa-user-circle icon-profile profile-image" aria-hidden="true"></i>
                    <img src="" alt="img-profile" width="200px" height="200px" class="profile-image rounded-circle d-none">
                <?php } ?>
                <? //= $form->field($model, 'image')->fileInput(['class' => 'd-none input-image-profile'])->label(false) 
                ?>
            </div>
            <?= Html::a('change image', Url::toRoute('/user/profile-image'), ['class' => 'btn btn-primary','data-toggle'=>"modal", 'data-target' => "#profileImageModal", 'data-pjax' => "0", 'onclick' => "modalLoadContent(this)"]) ?>
        </div>
        <div class="col">
            <!-- <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => "Username", 'readOnly' => true]) ?> -->
            <!-- <?= $form->field($model, 'email')->textInput()->input('email', ['placeholder' => "Email"]) ?> -->
            <!-- <?= $form->field($model, 'password')->passwordInput(['placeholder' => "Password"]) ?> -->
            <!-- <?= $form->field($model, 'confirm_password')->passwordInput(['placeholder' => "Confirm Password"]) ?> -->
            <?= $form->field($model, 'first_name', ['options' => ['class' => 'mb-3']])->textInput(['placeholder' => "First name"]) ?>
            <?= $form->field($model, 'last_name', ['options' => ['class' => 'mb-3']])->textInput(['placeholder' => "Last name"]) ?>
            <?= $form->field($model, 'phone', ['options' => ['class' => 'mb-3']])->textInput(['placeholder' => "Phone"]) ?>
            <?= $form->field($model, 'timezone', ['options' => ['class' => 'mb-3']])->dropDownList($timezoneOptions, ['value' => array_search($model->timezone, $timezoneOptions)]); ?>
            <?= $form->field($model, 'locale', ['options' => ['class' => 'mb-3']])->dropDownList($localeOptions, ['value' => array_search($model->locale, $localeOptions)]); ?>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            <div class="float-end ">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-lg']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
Modal::begin([
    "id" => "profileImageModal",
    "title" => "Update Profile image",
    "size" => Modal::SIZE_DEFAULT
]);
Modal::end();
?>

<script>
    function modalLoadContent(elm) {
        $(".modal-body", $(elm).attr('data-target')).load($(elm).attr('href'));
    }
</script>