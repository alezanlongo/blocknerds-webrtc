<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\ClinicalDocument */

$this->title = 'Update Clinical Document: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Clinical Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="clinical-document-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'                 => $model,
        'documentSubClasses'    => $documentSubClasses,
        'action'                => 'document/update'
    ]) ?>

</div>
