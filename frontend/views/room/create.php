<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Room */
/* @var $form ActiveForm */

$this->title = 'Welcome to Room!';

?>
<div class="room-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
        ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
        fugiat nulla pariatur.</p>

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::submitButton('Start a meeting', ['class' => 'btn btn-primary', 'id' => 'btnStart']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- room-create -->