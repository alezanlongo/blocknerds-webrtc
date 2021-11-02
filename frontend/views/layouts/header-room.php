<?php

/** @var \yii\web\View $this */
/** @var string $directoryAsset */

use yii\helpers\Html;

?>

<nav class="main-header navbar navbar-expand navbar-light m-0 header-nav d-none">
  <div class="container-fluid">
    <div class=" flex-grow-1 text-center">
      <span class="spanCountdown h4 text-danger"></span>
    </div>
    <!-- Right side -->
    <ul class="navbar-nav ms-auto">
      <li class="nav-item ml-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Toggle audio">
        <?= Html::tag('button', '<i class="fas fa-microphone icon-menu"></i>', [
          'id' => "mute",
          "class" => "btn btn-link text-white",
          'onclick' => "toggleMute()"
        ]) ?>
      </li>
      <li class="nav-item ml-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Toggle video">
        <?= Html::tag('button', '<i class="fas fa-video icon-menu"></i>', [
          'id' => "no-video",
          "class" => "btn btn-link text-white",
          'onclick' => "toggleVideo()"
        ]) ?>
      </li>
      <li class="nav-item ml-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Leave">
        <?= Html::tag('button', 'Leave', ["class" => "btn btn-danger btn-leave"]) ?>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </div>
</nav>