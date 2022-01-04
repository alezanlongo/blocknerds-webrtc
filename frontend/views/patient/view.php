<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Patient */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Patients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="patient-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Insurance', ['patient/create-insurance', 'patientId' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Create Appointment', ['appointment/create', 'patientid' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Create Patient Case', ['patient-case/create', 'patientid' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Create Chart Alert', ['patient-insurance/create-chart-alert', 'patientId' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Patient Problems', ['problem/index', 'patientid' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Privacy Information', ['privacy-information-verified/index', 'patientid' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Medical History', ['medical-history/index', 'patientid' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php if ($chartAlert->notetext): ?>
        <div class="alert alert-danger" role="alert">
            Chart Alert: <?= $chartAlert->notetext ?>
        </div>
    <?php endif ?>

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-striped table-bordered detail-view bg-light'
        ],
        'attributes' => [
            'id',
            'externalId',
            'departmentid',
            'dob',
            'email:email',
            'firstname',
            'lastname',
            'primarydepartmentid',
            'registrationdate',
            'status',
        ],
    ]) ?>

    <div class="row">
        <div class="col-6 margin-bottom p-3">
            <label for="document">Choose the document to create</label>
            <select class="form-select" name="document" id="document">
                <option value="">Select a Document</option>
                <?php foreach($documentsTypes as $key => $value): ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-6 margin-bottom p-3">
            <?= Html::a('Create Documents', [
                'document/create',
                'patientid'     => $model->externalId,
                'departmentid'  => $model->departmentid
            ], [
                'class' => 'btn btn-success disabled',
                'id'    => 'create-document'
            ]) ?>
        </div>
    </div>

    <?php if(count($documents) > 0): ?>
    <div class="row">
        <table class="table table-striped table-bordered bg-light">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">documentID</th>
                <th scope="col">documentsubclass</th>
                <th scope="col">documentclass</th>
                <th scope="col">type</th>
                <th scope="col">view</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($documents as $key => $value): ?>
                <tr>
                    <th><?= $value['id'] ?></th>
                    <th><?= $value['documentID'] ?></th>
                    <td><?= $value['documentsubclass'] ?></td>
                    <td><?= $value['documentclass'] ?></td>
                    <td><?= $value['type'] ?></td>
                    <td>
                        <?= Html::a(
                            'Documnent',
                            [
                                'document/view',
                                'id'        => $value['id'],
                                'patientid' => $model->patientid,
                                'type'      => $value['type']
                            ],
                            ['title' => 'Documnent',],
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <h4>Active Insurances</h4>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'class' => 'table table-striped table-bordered bg-light'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'insuranceid',
            'insuranceidnumber',
            'insuranceplanname',
            'insurancepolicyholderfirstname',
            'insurancepolicyholderlastname',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view-insurance} {update-insurance} {delete-insurance}',
                'buttons' => [
                    'view-insurance' => function ($url, $model) {
                        $url .="&patientid=".$model->patient_id;
                        return Html::a(
                            '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z"></path></svg>',
                            [$url],
                        );
                    },
                    'update-insurance' => function ($url) {
                        return Html::a(
                            '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"/></svg>',
                            [$url],
                        );
                    },
                    'delete-insurance' => function ($url) {
                        return Html::a(
                            '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"/></svg>',
                            [$url],
                        );
                    },
                ],

            ],

        ],
    ]); ?>
</div>

<?php $this->registerJsFile(
    '@web/js/Athena/patient-document.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
); ?>
