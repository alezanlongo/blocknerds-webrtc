<?php

use frontend\assets\adminlte\AdminLteAsset;
use frontend\assets\fontawesome\FontAwesomeAsset;
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

  if (class_exists('backend\assets\AppAsset')) {
    backend\assets\AppAsset::register($this);
  } else {
    frontend\assets\AppAsset::register($this);
  }

  AdminLteAsset::register($this);
  // FontAwesomeAsset::register($this);
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
        'header.php', []
      ) ?>

      <?= $this->render(
        'left.php',[]
      )
      ?>

      <?= $this->render(
        'content.php',
        ['content' => $content]
      ) ?>

    </div>



    <!-- <script src="/adminlte/js/adminlte.js"></script>
    <script src="/adminlte/vendor/overlayscrollbars/js/OverlayScrollbars.min.js"></script> -->
    <?php $this->endBody() ?>
  </body>

  </html>
  <?php $this->endPage() ?>
<?php } ?>