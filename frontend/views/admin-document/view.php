<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\AdminDocument */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Admin Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="admin-document-view">

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
            'actionnote',
            'adminid',
            'appointmentid',
            'assignedto',
            'clinicalproviderid',
            'createddate',
            'createddatetime',
            'createduser',
            'deleteddatetime',
            'departmentid',
            'description',
            'documentclass',
            'documentdata',
            'documentdate',
            'documentroute',
            'documentsource',
            'documentsubclass',
            'documenttypeid',
            'encounterid',
            'entitytype',
            'externalaccessionid',
            'externalnote',
            'internalaccessionid',
            'internalnote',
            'lastmodifieddate',
            'lastmodifieddatetime',
            'lastmodifieduser',
            'originaldocument',
            'priority',
            'providerid',
            'providerusername',
            'status',
            'subject',
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
                                'document/view-page',
                                'pageid'    => $value->pageid,
                                'type'      => $type
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
