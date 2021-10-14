<?php

use frontend\widgets\adminlte\Alert;

?>
<div class="content-wrapper">
    <section class="content">
        <div class="">
            <?= Alert::widget([
                'options' => ['class' => 'alert-style'],
            ]) ?>
        </div>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.0.2
    </div>
    <strong>Copyright © 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
</footer>