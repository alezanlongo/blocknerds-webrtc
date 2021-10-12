<?php

use yii\helpers\Html;

$formatter = \Yii::$app->formatter;

?>

<div class="row m-1">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body d-flex row">
                <div class="flex-grow-1 col">
                    <h5 class="card-title "><?= $title ?></h5>
                    <p class="card-text "><?= $text ?></p>
                </div>
               <div class="col text-end">
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
</div>