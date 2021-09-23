<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Departments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Department', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'address',
            'address2',
            'chartsharinggroupid',
            'city',
            'clinicalproviderfax',
            //'clinicals',
            //'communicatorbrandid',
            //'creditcardtypes',
            //'departmentid',
            //'doesnotobservedst',
            //'ecommercecreditcardtypes',
            //'fax',
            //'ishospitaldepartment',
            //'latitude',
            //'longitude',
            //'medicationhistoryconsent',
            //'name',
            //'oneyearcontractmax',
            //'patientdepartmentname',
            //'phone',
            //'placeofservicefacility',
            //'placeofservicetypeid',
            //'placeofservicetypename',
            //'portalurl',
            //'providergroupid',
            //'providergroupname',
            //'providerlist',
            //'servicedepartment',
            //'singleappointmentcontractmax',
            //'state',
            //'timezone',
            //'timezonename',
            //'timezoneoffset',
            //'zip',
            //'external_id',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
