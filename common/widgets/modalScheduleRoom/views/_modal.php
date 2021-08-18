<?php

use common\models\User;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\web\JsExpression;

Modal::begin([
    'title' => 'Planning a meeting...',
    'id' => 'planningMeeting',
    'footer' => Html::submitButton('Create', ['class' => 'btn btn-primary', 'onclick' => "createSchedule();return false;"])
]);

$form = ActiveForm::begin([
    'id' => 'formCreateSchedule',
]);
?>

<div class="container">
    <div class="modal-body">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="control-label" for="title">Title</label>
                    <?= Html::input('text', 'title', null, ['class' => 'form-control']) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col text-center">
                <p class="control-label text-left" for="datetimepicker">Date & time</p>
                <input type="text" name="datetimepicker" id="datetimepicker">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="control-label" for="duration">Duration</label>
                    <?
                    echo Html::dropDownList(
                        'duration',
                        null,
                        $itemsDuration,
                        ['class' => 'form-control', 'prompt' => 'Select duration'],
                    );
                    ?>
                </div>
            </div>
        </div>

        <?
        echo $form->field(new User, 'username')->widget(Select2::class, [
            'options' => ['multiple' => true, 'placeholder' => 'Search for a user ...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 2,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => \yii\helpers\Url::to(['user-list']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(user) { return user.username; }'),
                'templateSelection' => new JsExpression('function (user) { return user.username; }'),
            ],
        ]);
        ?>

    </div>
</div>

<?
ActiveForm::end();

Modal::end();

?>