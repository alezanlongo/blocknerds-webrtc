<?php

/** @var \yii\web\View $this */
/** @var string $directoryAsset */

use yii\helpers\Html;
use yii\helpers\VarDumper;

$username = Yii::$app->getUser()->getIdentity()->username;
$image = Yii::$app->getUser()->getIdentity()->getUserProfile()->one()->image;

if ($image === null) {
    $image = "/img/default-user.png";
}
?>

<!-- <nav class="main-header navbar navbar-expand navbar-white navbar-light"> -->
<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?= $image ?>" class="user-image <?= $image ?> " alt="User Image">
                <span class="d-none d-md-inline"><?= $username ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="<?= $image ?>" class="<?= $image ?>" alt="User Image">

                    <p>
                        <?= $username ?>
                        <!-- <small>Member since Nov. 2012</small> -->
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <!-- <a href="user/" class="btn btn-default btn-flat">Profile</a> -->
                    <?= Html::a(
                        'Profile',
                        ['/user/edit-profile'],
                        ['class' => 'btn btn-default btn-flat']
                    ) ?>
                    <?= Html::a(
                        'Logout',
                        ['/site/logout'],
                        ['data-method' => 'post', 'class' => 'btn btn-default btn-flat float-right']
                    ) ?>
                </li>
            </ul>
        </li>
    </ul>
</nav>