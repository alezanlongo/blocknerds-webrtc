<?php

use kartik\select2\Select2;
use yii\web\JsExpression;


echo $form->field($model, $name)->widget(Select2::classname(), [
    'options' => ['placeholder' => 'Search by term ...', 'multiple' => false],
    'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 2,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => \yii\helpers\Url::to(['snomed/search']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(snomed) { return snomed.name; }'),
            'templateSelection' => new JsExpression('function (snomed) { return snomed.name; }'),
        ],
]);
