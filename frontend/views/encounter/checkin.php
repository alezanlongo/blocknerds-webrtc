<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $patientid integer */
/* @var $departmentid integer */
/* @var $appointmentid integer */
/* @var $error boolean */
/* @var $message string */

$this->title = "Checkin";
$this->params['breadcrumbs'][] = ['label' => 'Encounters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="start-checkin-view">
    <?php if(!$error): ?>
        <h1><?= Html::encode("The Checkin is complete") ?></h1>
        <p>
            <?= Html::a('Checkin', [
                'encounter/index',
                'patientid'     => $patientid,
                'departmentid'  => $departmentid
            ], ['class' => 'btn btn-primary']) ?>
        </p>
    <?php else: ?>
        <h1><?= Html::encode("The Checkin is not complete") ?></h1>
        <h2><?= Html::encode($message) ?></h2>
    <?php endif; ?>
</div>
