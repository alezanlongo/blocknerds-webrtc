<?php

/** @var \yii\web\View $this */
/** @var string $directoryAsset */

use yii\helpers\Html;

$username = Yii::$app->getUser()->getIdentity()->username;
$image = Yii::$app->getUser()->getIdentity()->getUserProfile()->one()->image;

if ($image === null) {
  $image = "/img/default-user.png";
}
?>

<nav class="main-header navbar navbar-expand navbar-light">
  <div class="container-fluid">
    <!-- Start navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar-full" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <img src="<?= $image ?>" class="user-image <?= $image ?> shadow" alt="User Image">
          <span class="d-none d-md-inline"><?= $username ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <!-- User image -->
          <li class="user-header bg-primary">
            <img src="<?= $image ?>" class="<?= $image ?> shadow" alt="User Image">

            <p>
              <?= $username ?>
            </p>
          </li>
          <li class="user-footer">
            <?= Html::a(
              'Profile',
              ['/user/edit-profile'],
              ['class' => 'btn btn-default btn-flat']
            ) ?>
            <?= Html::a(
              'Logout',
              ['/site/logout'],
              ['data-method' => 'post', 'class' => 'btn btn-default btn-flat float-end']
            ) ?>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>