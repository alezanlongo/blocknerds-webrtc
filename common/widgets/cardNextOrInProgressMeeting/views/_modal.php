<?php

use yii\helpers\Html;

$formatter = \Yii::$app->formatter;

?>

<div class="row m-1">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body d-flex ">
                <div class="flex-grow-1">
                    <h5 class="card-title "><?= $title ?></h5>
                    <p class="card-text "><?= $text ?></p>
                </div>
               <div>
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