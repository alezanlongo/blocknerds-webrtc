<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\AdminDocument */

$this->title = 'Create Admin Document';
$this->params['breadcrumbs'][] = ['label' => 'Admin Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-document-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'                 => $model,
        'documentSubClasses'    => $documentSubClasses,
        'action'                => 'document/create?patientid='.$patientid.'&departmentid='.$departmentid.'&type='.$type
    ]) ?>

</div>
