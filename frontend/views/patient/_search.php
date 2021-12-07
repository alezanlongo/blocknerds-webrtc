<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="patient-search-form">
    <?php 
    $form = ActiveForm::begin([
        'id' => 'patients-search-form',
        'method' => 'GET',
        'action' => ['index'],
    ]);
    ?>
    <?= $form->field($searchModel, 'firstname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($searchModel, 'lastname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($searchModel, 'dob')->textInput(['maxlength' => true]) ?>
    <?=  Html::submitButton('Search', ['class' => 'btn btn-primary']); ?>
    <?=  Html::button('Search External', ['class' => 'btn btn-primary', 'id' => 'patients-external-search-button']); ?>
    <?php $form->end(); ?>
</div>
