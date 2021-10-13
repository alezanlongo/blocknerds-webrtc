<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Patient */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Appointments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="appointments-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['action' => ['encounter/startcheckin']]); ?>

    <?= $form->field($model, 'patientid')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'departmentid')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'appointmentid')->hiddenInput()->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Checkin', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-striped table-bordered detail-view bg-light'
            ],
        'attributes' => [
            'id',
            'externalId',
            'appointmentstatus',
            'date',
            'duration',
            'departmentid',
            'appointmenttypeid',
            'patientappointmenttypename',
            'providerid',
            'starttime',
        ],
    ]) ?>

</div>
