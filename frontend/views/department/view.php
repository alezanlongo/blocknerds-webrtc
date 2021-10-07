<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Department */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Departments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="department-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'address',
            'address2',
            'chartsharinggroupid',
            'city',
            'clinicalproviderfax',
            'clinicals',
            'communicatorbrandid',
            'creditcardtypes',
            'departmentid',
            'doesnotobservedst',
            'ecommercecreditcardtypes',
            'fax',
            'ishospitaldepartment',
            'latitude',
            'longitude',
            'medicationhistoryconsent',
            'name',
            'oneyearcontractmax',
            'patientdepartmentname',
            'phone',
            'placeofservicefacility',
            'placeofservicetypeid',
            'placeofservicetypename',
            'portalurl',
            'providergroupid',
            'providergroupname',
            'providerlist',
            'servicedepartment',
            'singleappointmentcontractmax',
            'state',
            'timezone',
            'timezonename',
            'timezoneoffset',
            'zip',
            'external_id',
            'id',
        ],
    ]) ?>

</div>
