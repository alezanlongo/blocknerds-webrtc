<?php

use yii\helpers\Url;
use yii\web\View;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\ClinicalDocument */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Clinical Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="clinical-document-view">

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
        'options' => [
            'class' => 'table table-striped table-bordered bg-light'
        ],
        'attributes' => [
            'patientid',
            'actionnote',
            'assignedto',
            'clinicaldocumentid',
            'clinicalproviderid',
            'createddate',
            'createddatetime',
            'createduser',
            'departmentid',
            'documentclass',
            'documentdata',
            'documentdescription',
            'documentroute',
            'documentsource',
            'documentsubclass',
            'documenttypeid',
            'externalnote',
            'internalnote',
            'lastmodifieddate',
            'lastmodifieddatetime',
            'lastmodifieduser',
            'observationdate',
            'ordertype',
            'priority',
            'providerid',
            'providerusername',
            'status',
            'tietoorderid',
            'externalId',
            'id',
        ],
    ]) ?>

    <div class="row">
        <table class="table table-striped table-bordered bg-light">
            <thead>
                <tr>
                    <th scope="col">pageid</th>
                    <th scope="col">pageordering</th>
                    <th scope="col">externalId</th>
                    <th scope="col">view</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($pageDetail as $key => $value): ?>
                <tr>
                    <th scope="row"><?= $value->pageid ?></th>
                    <td><?= $value->pageordering ?></td>
                    <td><?= $value->externalId ?></td>
                    <td>
                        <?= Html::a(
                            'Documnent',
                            [
                                'view-page',
                                'pageid'    => $value->pageid,
                            ],
                            ['title' => 'Documnent',],
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

