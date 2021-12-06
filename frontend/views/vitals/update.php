<?php

use yii\helpers\Html;
use common\components\Athena\helpers\VitalsHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Vitals */

$this->title = 'Update Vital: ';
$this->params['breadcrumbs'][] = ['label' => 'Vitals', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="vitals-update">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(); ?>
    <?php
    foreach($vitalsConfiguration as $vitalsReference){ ?>
        <?= VitalsHelper::render($vitalsReference, $vitaltsByClinicalId); ?>
    <?php } ?>


    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>


    <?php ActiveForm::end(); ?>
</div>
