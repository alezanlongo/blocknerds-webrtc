<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\insurancePackages */

$this->title = 'Create Insurance Packages';
$this->params['breadcrumbs'][] = ['label' => 'Insurance Packages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insurance-packages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'create-insurancepackages-form']); ?>

            <?= $form->field($model, 'insuranceplanname')->dropdownList($departments,
                ['prompt'=>'Select Insurance Plan']
            );?>

            <?= $form->field($model, 'lastname')->textInput() ?>

            <?= $form->field($model, 'dob')->textInput() ?>



            <?= $form->field($model, 'email')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Create Patient', ['class' => 'btn btn-primary', 'name' => 'create-patient-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
