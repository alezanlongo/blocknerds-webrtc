<?php

use yii\helpers\Html;
use yii\widgets\Pjax;


?>
<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($photos as $photo) { ?>
        <div class="col">
            <div class="card">
                <?= Html::img($photo->url, ['class' => 'card-img-top', 'alt' => "image"]) ?>
                <div class="card-body">
                    <?= Html::tag('p', $photo->description ?? '', ['class' => 'card-text']) ?>
                    <?= Html::tag('p', $photo->alt_description ?? '', ['class' => 'card-text']) ?>
                </div>
            </div>
        </div>

    <?php } ?>

</div>