<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\InsuranceCardImage */

$this->title = 'Create Insurance Card Image';
$this->params['breadcrumbs'][] = ['label' => 'Insurance Card Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insurance-card-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'         => $model,
        'departmentid'  => $departmentid,
    ]) ?>

</div>
