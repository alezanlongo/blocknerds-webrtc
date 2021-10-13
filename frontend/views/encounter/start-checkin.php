<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $patientid integer */
/* @var $departmentid integer */
/* @var $appointmentid integer */
/* @var $error boolean */
/* @var $message string */

$this->title = "Start Checkin";
$this->params['breadcrumbs'][] = ['label' => 'Encounters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="start-checkin-view">
    <?php if(!$error): ?>
    <h1><?= Html::encode("The Checkin is Started") ?></h1>
    <p>
        <?= Html::a('Checkin', [
            'checkin',
            'patientid'     => $patientid,
            'departmentid'  => $departmentid,
            'appointmentid' => $appointmentid
        ], ['class' => 'btn btn-primary']) ?>
    </p>
    <?php else: ?>
    <h1><?= Html::encode("The Checkin is not Started") ?></h1>
    <h2><?= Html::encode($message) ?></h2>
    <?php endif; ?>
</div>
