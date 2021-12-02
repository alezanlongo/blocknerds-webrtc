<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\AdminDocument */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-document-form">

    <?php $form = ActiveForm::begin([
        'options'   => ['enctype' => 'multipart/form-data'],
        'action'    => [$action]
    ]); ?>

    <div class="form-group">
        <?= $form->field($model, 'documentsubclass')->dropdownList(
            $documentSubClasses,
            ['prompt'=>'Select a subclass']
        );?>

        <?= $form->field($model, 'departmentid')->hiddenInput() ?>

        <?= Html::fileInput("document", ""); ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
