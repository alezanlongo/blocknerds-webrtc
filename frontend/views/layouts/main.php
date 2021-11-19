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
$this->registerJsFile(
  Yii::$app->request->BaseUrl . '/js/sidebarIcon.js',
  [
    'depends' => [
      "yii\web\JqueryAsset",
    ],
    'position' => View::POS_END
  ]
);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
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

    .rotate {
      -moz-transition: all .3s linear;
      -webkit-transition: all .3s linear;
      transition: all .3s linear;
    }

    .rotate.down {
      -moz-transform: rotate(180deg);
      -webkit-transform: rotate(180deg);
      transform: rotate(180deg);
    }
    #offcanvasMainMenu a {
      color: white;
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
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
  </script>

</body>

<?php $this->endPage() ?>

</html>