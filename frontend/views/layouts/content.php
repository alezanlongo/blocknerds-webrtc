<?php

use frontend\widgets\adminlte\Alert;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<main role="main" class="flex-shrink-0">
    <div class="container-fluid min-h-100">
        <?php Pjax::begin(['id' => 'flash-alert-message']) ?>
        <?= Alert::widget([
            'options' => ['class' => 'alert-style'],
        ]) ?>
        <?php Pjax::end() ?>
        <?= $content ?>
    </div>
</main>


<footer class="footer mt-auto py-3 main-footer">
    <div class="container-fluid">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>

<!-- <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.0.2
    </div>
    <strong>Copyright © 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
</footer> -->