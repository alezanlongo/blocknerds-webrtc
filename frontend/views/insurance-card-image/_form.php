<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\InsuranceCardImage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="insurance-card-image-form">

    <?php $form = ActiveForm::begin([
        'options'   => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= Html::fileInput("document", ""); ?>
    <?= $form->field($model, 'departmentid')->hiddenInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
