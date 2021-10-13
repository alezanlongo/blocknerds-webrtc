<!DOCTYPE html>
<html lang="en">
<!-- For RTL verison -->
<!-- <html lang="en" dir="rtl"> -->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- Primary Meta Tags -->
  <title>AdminLTE 4 | Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="title" content="AdminLTE 4 | Dashboard">
  <meta name="author" content="ColorlibHQ">
  <meta name="description" content="Volt Pro is a Premium Bootstrap 5 Admin Dashboard featuring over 800 components, 10+ plugins and 20 example pages using Vanilla JS.">
  <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard" />
  <!-- By adding ./css/dark/adminlte-dark-addon.css then the page supports both dark color schemes, and the page author prefers / default is light. -->
  <meta name="color-scheme" content="light dark">
  <!-- By adding ./css/dark/adminlte-dark-addon.css then the page supports both dark color schemes, and the page author prefers / default is dark. -->
  <!-- <meta name="color-scheme" content="dark light"> -->
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/adminlte/vendor/@fortawesome/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/adminlte/css/adminlte.css">

  <!-- For RTL verison use ./css/rtl/adminlte.rtl.css, remove dist/css/adminlte.css -->
  <!-- <link rel="stylesheet" href="./css/rtl/adminlte.rtl.css""> -->

  <!-- For dark mode use ./css/dark/adminlte-dark-addon.css, do not remove dist/css/adminlte.css or if usinf RTL version do not remove ./css/rtl/adminlte.rtl.css-->
  <!-- ... and then the alternate CSS first as a snap-on for dark color scheme preference -->
  <link rel="stylesheet" href="/adminlte/css/dark/adminlte-dark-addon.css" media="(prefers-color-scheme: dark)">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/adminlte/vendor/overlayscrollbars/css/OverlayScrollbars.min.css">

  <?php

  frontend\assets\AppAsset::register($this);
  $directoryAsset = '/adminlte/assets';

  ?>
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
</head>

<body class="layout-fixed ">
  <div class="wrapper">
    <!-- Navbar -->
    <?= $this->render(
      'header.php',
      ['directoryAsset' => $directoryAsset]
    ) ?>


    <!-- Main Sidebar Container -->
    <?= $this->render(
      'left.php',
      ['directoryAsset' => $directoryAsset]
    )
    ?>

    <!-- Main content -->
    <?= $this->render(
      'content.php',
      ['content' => $content, 'directoryAsset' => $directoryAsset]
    ) ?>


  </div>

  <!-- REQUIRED SCRIPTS -->
  <!-- overlayScrollbars -->
  <script src="/adminlte/vendor/overlayscrollbars/js/OverlayScrollbars.min.js"></script>
  <!-- Bootstrap 5 -->
  <script src="/adminlte/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/adminlte/js/adminlte.js"></script>


  <!-- ChartJS -->
  <!-- <script src="adminlte/vendor/chart.js/dist/chart.js"></script> -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="adminlte/assets/js/dashboard.js"></script> -->
</body>

</html>