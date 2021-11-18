<?php

use frontend\assets\adminlte\AdminLteAsset;
use frontend\assets\AppAsset;
use frontend\assets\masonry\MasonryAsset;
use frontend\assets\mqtt\MqttAsset;
use yii\helpers\Html;
use yii\web\View;

/** @var \yii\web\View $this */
/** @var string $content */

$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700');

  AppAsset::register($this);
  $this->registerAssetBundle(MqttAsset::class);
  AdminLteAsset::register($this);
  MasonryAsset::register($this);

  $this->registerJs("var myOffcanvas = document.getElementById('offcanvasMainMenu')
  myOffcanvas.addEventListener('show.bs.offcanvas', function () {
    myOffcanvas.classList.remove('d-none')
  })
  myOffcanvas.addEventListener('hide.bs.offcanvas', function () {
    myOffcanvas.classList.add('d-none')
  })
  ", View::POS_READY);
?>

  <?php $this->beginPage() ?>
  <!DOCTYPE html>
  <html lang="<?= Yii::$app->language ?>" class="h-100">

  <head >
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <style>
      .alert-style {
        position: fixed;
        z-index: 9999;
        top: 0;
        right: 0;
      }
    </style>
  </head>

  <body class="d-flex min-h-100">
    <?php $this->beginBody() ?>
    <?= $this->render(
      'sidebarOffcanvas.php',
      []
    ) ?>

    <div class="min-h-100 d-flex flex-column w-100" id="main-wrapper">

      <?= $this->render(
        'header.php',
        []
      ) ?>

      <?= $this->render(
        'content.php',
        ['content' => $content]
      ) ?>

      <?= Html::tag('div', '', ['class' => 'chat-zone d-flex justify-content-end']) ?>
    </div>

    <?php $this->endBody() ?>
    <script>
      // const myOffcanvasMenu = document.getElementById('offcanvasMainMenu')
      // const wrapperContainer = document.getElementById('main-wrapper')
      // myOffcanvasMenu.addEventListener('shown.bs.offcanvas', function() {
      //   // wrapperContainer.style.marginLeft = `${myOffcanvasMenu.offsetWidth}px`
      // })
      // myOffcanvasMenu.addEventListener('hidden.bs.offcanvas', function() {
      //   Object.assign(wrapperContainer.style, {transition: "0.3s ease-in-out", marginLeft: `0px`})
      //   Object.assign(myOffcanvasMenu.style, {width: "0px"})
      // })
      // myOffcanvasMenu.addEventListener('show.bs.offcanvas', function() {
      //   Object.assign(wrapperContainer.style, {transition: "0.3s ease-in-out",marginLeft: `${myOffcanvasMenu.offsetWidth}px`})
      //   Object.assign(myOffcanvasMenu.style, {width: "400px"})
      // })
      // myOffcanvasMenu.addEventListener('hide.bs.offcanvas', function() {
      // })
    </script>

  </body>

  <?php $this->endPage() ?>

  </html>