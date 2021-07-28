<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\widgets\Pjax;
use yii\web\View;

/** @var View $this */

$this->registerJs(
    <<<JS
function setSelectedOptions(elmId){
    $('option','#'+elmId).prop('selected', true);
}
JS,View::POS_END)
?>

<div class="container">
    <div class="row">
        <div class="col-md-12" id="create-video-room-container">
            <?php
            $rm = [];
            if (isset($model->roomMembers)) {
                foreach ($model->roomMembers as $v) {
                    if (!empty($v)) {
                        $rm[$v] = $v;
                    }
                }
            }

            Pjax::begin(['id' => 'create-video-room-container']);
            // var_dump($model->roomMembers);
            $form = ActiveForm::begin(['id' => 'create-video-room', 'options' => ['data-pjax' => true, 'onSubmit' => "setSelectedOptions('" . Html::getInputId($model, 'roomMembers') . "')"]]);
            ?>
            <?= $form->field($model, 'addMembers')->textInput(); ?>
            <?= Html::submitButton('Add User', ['name' => 'addUser', 'class' => 'btn btn-success btn-sm']) ?>
            <?= $form->field($model, 'roomMembers')->listBox($rm, ['multiple'=>true]); ?>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-sm']) ?>
            <?php
            ActiveForm::end();
            Pjax::end();
            ?>
        </div>
    </div>
</div>