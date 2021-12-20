<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use frontend\widgets\snomedAutocomplete\SnomedAutocomplete;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\JsExpression;

$this->title = 'Create Order (Prescription)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create a new Order (Prescription):</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'create-order-prescription-form']); ?>

                <?= SnomedAutocomplete::widget([
                        'name' => 'diagnosissnomedcode',
                        'form' => $form,
                        'model' => $model,
                    ]
                ); ?>

                <?= $form->field($model, 'ordertypeid')->widget(Select2::classname(), [
                    'options' => ['placeholder' => 'Search for a orderable medication ...', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 2,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => \yii\helpers\Url::to(['orderable-medications']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(medication) { return medication.name; }'),
                        'templateSelection' => new JsExpression('function (medication) { return medication.name; }'),
                    ],
                ]); ?>

                <?= $form->field($model, 'ndc')->textInput() ?>

                <?= $form->field($model, 'rxnormid')->textInput() ?>

                <?= $form->field($model, 'frequency')->widget(Select2::classname(), [
                    'options' => ['placeholder' => 'Search for a frequency ...', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 2,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => \yii\helpers\Url::to(['frequencies']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(frequency) { return frequency.frequency; }'),
                        'templateSelection' => new JsExpression('function (frequency) { return frequency.frequency; }'),
                    ],
                ]); ?>

                <?= $form->field($model, 'dosagequantity')->textInput() ?>

                <?= $form->field($model, 'dosagequantityunit')->widget(Select2::classname(), [
                    'options' => ['placeholder' => 'Search for a unit ...', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => \yii\helpers\Url::to(['dosage-units']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(dosageUnit) { return dosageUnit.quantityunit; }'),
                        'templateSelection' => new JsExpression('function (dosageUnit) { return dosageUnit.quantityunit; }'),
                    ],
                ]); ?>

                <?= $form->field($model, 'totalquantity')->textInput() ?>

                <?= $form->field($model, 'totalquantityunit')->widget(Select2::classname(), [
                    'options' => ['placeholder' => 'Search for a unit ...', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => \yii\helpers\Url::to(['total-quantity']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(totalQuantity) { return totalQuantity.quantityunit; }'),
                        'templateSelection' => new JsExpression('function (totalQuantity) { return totalQuantity.quantityunit; }'),
                    ],
                ]); ?>




                <div class="form-group">
                    <?= Html::submitButton('Create Order (Prescription)', ['class' => 'btn btn-primary', 'name' => 'create-order-prescription-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
