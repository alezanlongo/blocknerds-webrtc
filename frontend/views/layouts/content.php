<?php

use yii\bootstrap5\Alert;

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
