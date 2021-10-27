<?php

use frontend\assets\adminlte\AdminLteAsset;
use frontend\assets\AppAsset;
use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $content */

$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700');
if (Yii::$app->controller->action->id === 'login') {
  echo $this->render(
    'main-login',
    ['content' => $content]
  );
} else {

  AppAsset::register($this);
  AdminLteAsset::register($this);
?>

  <?php $this->beginPage() ?>
  <!DOCTYPE html>
  <html lang="<?= Yii::$app->language ?>">

  <head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <style>
      .alert-style {
        width: fit-content;
        float: right;
      }
    </style>
  </head>

  <body class="layout-fixed ">
    <?php $this->beginBody() ?>
    <div class="wrapper">
      <?= $this->render(
        'header.php',
        []
      ) ?>

      <?= $this->render(
        'left.php',
        []
      ) ?>

      <?= $this->render(
        'content.php',
        ['content' => $content]
      ) ?>

      <?= $this->render(
        'right.php',
        []
      ) ?>
      <div class="chat-zone d-flex justify-content-end">

      </div>
    </div>

    <?php $this->endBody() ?>
  </body>

  </html>
  <?php $this->endPage() ?>
<?php } ?>