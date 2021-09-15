<?php

use yii\helpers\Html;

$formatter = \Yii::$app->formatter;

?>

<div class="row mb-3">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-dark"><?= $title ?></h5>
                <p class="card-text text-dark"><?= $text ?></p>
                <?php
                echo Html::a(
                    "Go to meeting",
                    $url,
                    [
                        "target" => "_blank",
                        "class" => "btn btn-primary target-blank"
                    ]
                );
                ?>
            </div>
        </div>
    </div>
</div>