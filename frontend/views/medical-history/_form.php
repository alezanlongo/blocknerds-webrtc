<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\MedicalHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medical-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sectionnote')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <div class="row table-responsive m-3">
        <table class="table table-dark" >
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Choose</th>
                    <th>ID</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($questions as $key => $value): ?>
                <tr>
                    <td><?= $value->question; ?></td>
                    <td>
                        <select class="custom-select" name="response[<?= $value->questionid; ?>]" id="response-<?= $value->questionid; ?>">
                            <option value="">None</option>
                            <option value="Y" <?php if($value->answer == 'Y'): ?>selected<?php endif; ?>>Yes</option>
                            <option value="N" <?php if($value->answer == 'N'): ?>selected<?php endif; ?>>No</option>
                        </select>
                    </td>
                    <td><?= $value->questionid; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
