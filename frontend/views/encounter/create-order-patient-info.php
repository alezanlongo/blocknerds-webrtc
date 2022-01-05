<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use frontend\widgets\snomedAutocomplete\SnomedAutocomplete;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\JsExpression;

$this->title = 'Create Order (Patient Info)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create a new Order (Patient Info):</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'create-order-patient-info-form']); ?>

                <?= SnomedAutocomplete::widget([
                        'name' => 'diagnosissnomedcode',
                        'form' => $form,
                        'model' => $model,
                    ]
                ); ?>

                <?= $form->field($model, 'ordertypeid')->widget(Select2::classname(), [
                    'options' => ['placeholder' => 'Search for a handout ...', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 2,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => \yii\helpers\Url::to(['patient-info-handouts']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(handout) { return handout.name; }'),
                        'templateSelection' => new JsExpression('function (handout) { return handout.name; }'),
                    ],
                ]); ?>


                <div class="form-group">
                    <?= Html::submitButton('Create Order (Patient Info)', ['class' => 'btn btn-primary', 'name' => 'create-order-patient-info-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
