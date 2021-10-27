<?php

/** @var \yii\web\View $this */

use common\models\User;
use common\widgets\chat\ChatWidget;
use frontend\widgets\adminlte\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

/** @var string $directoryAsset */

$items = [];
$items[] = ['label' => 'Home', 'icon' => 'fas fa-home', 'url' => ['/']];
$items[] =  [
  'label' => 'Chat',
  'template' => '<a class="nav-link" href="{url}" data-bs-toggle="offcanvas" role="button" aria-controls="offcanvasScrolling">{icon}{label}</a>',
  'url' => '#offcanvasScrolling',
  'icon' => 'far fa-comments"',
  'visible' => !Yii::$app->user->isGuest,
];

if (Url::home() === Yii::$app->request->url) {
  $items[] = ['template' => '<hr>'];
  $items[] = ['label' => 'Menu room options ', 'header' => true];
  $items[] = [
    'label' => 'Create new meet',
    'template' => '<a class="nav-link" href="{url}" data-method="post">{icon}{label}</a>',
    'url' => ['room/create'],
    'icon' => 'fas fa-phone-alt',
    'visible' => !Yii::$app->user->isGuest,
  ];
  $items[] =  [
    'label' => 'Planning a meeting',
    'template' => '<a class="nav-link" href="{url}" onclick="$(\'#planningMeeting\').modal(\'show\');return false;">{icon}{label}</a>',
    'url' => null,
    'icon' => 'far fa-calendar-plus',
    'visible' => !Yii::$app->user->isGuest,
  ];
  $items[] =  [
    'label' => 'Run diagnostic',
    'template' => '<a class="nav-link" href="{url}">{icon}{label}</a>',
    'url' => ['/diagnostic'],
    'icon' => 'far fa-bug',
    'visible' => !Yii::$app->user->isGuest,
  ];
  $items[] =  [
    'label' => 'Run echotest',
    'template' => '<a class="nav-link" href="{url}">{icon}{label}</a>',
    'url' => ['/diagnostic/echo-test'],
    'icon' => 'far fa-bug',
    'visible' => !Yii::$app->user->isGuest,
  ];
}
$items[] = ['label' => 'Menu profile options ', 'header' => true];
$items[] = ['label' => 'Profile', 'icon' => 'far fa-user-circle', 'url' => ['/user/edit-profile']];
$items[] = ['template' => '<hr>'];
$items[] = ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest];
$items[] = [
  'label' => 'Logout',
  'template' => '<a class="nav-link" href="{url}" data-method="post">{icon}{label}</a>',
  'url' => ['site/logout'],
  'icon' => 'sign-out-alt',
  'visible' => !Yii::$app->user->isGuest,
];
$users = User::find()->all();

?>

<aside class="main-sidebar sidebar-bg-dark sidebar-color-primary shadow">
  <div class="brand-container">
    <?= Html::a('<img class="brand-image img-circle elevation-3 opacity-80 shadow" href="javascript:;" src="' . ('/img/AdminLTELogo.png') . '" alt="APP"><span class="brand-text font-weight-light">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'brand-link']) ?>
    <a class="pushmenu mx-1" data-lte-toggle="sidebar-mini" href="javascript:;" role="button"><i class="fas fa-angle-double-left"></i></a>
  </div>
  <!-- Sidebar -->
  <div class="sidebar">
    <nav class="mt-2">
      <?= Menu::widget(
        [
          'options' => ['class' => 'nav nav-pills nav-sidebar flex-column', 'data-widget' => 'treeview'],
          'items' => $items,
        ]
      ) ?>
    </nav>
  </div>
  <!-- /.sidebar -->
</aside>
<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Chat</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
  <?= 
      ChatWidget::widget([
        'users'=> $users,
      ])  
    ?>
  </div>
</div>