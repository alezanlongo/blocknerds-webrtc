<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\JsExpression;

$this->title = 'Create Medication';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create a new Medication:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'create-medication-form']); ?>

                <?= $form->field($model, 'departmentid')->textInput(['value' => $patient->departmentid, 'readonly' => true]) ?>

                <?= $form->field($model, 'medicationid')->widget(Select2::classname(), [
                    'options' => ['placeholder' => 'Search for a medication ...', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 2,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => \yii\helpers\Url::to(['medications']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(medication) { return medication.medication; }'),
                        'templateSelection' => new JsExpression('function (medication) { return medication.medication; }'),
                    ],
                ]); ?>

                <div class="form-group">
                    <?= Html::submitButton('Create Medication', ['class' => 'btn btn-primary', 'name' => 'create-medication-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
