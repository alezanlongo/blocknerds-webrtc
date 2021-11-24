<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\ClinicalDocumentPage */

$this->title = 'Create Clinical Document Page';
$this->params['breadcrumbs'][] = ['label' => 'Clinical Document Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clinical-document-page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
