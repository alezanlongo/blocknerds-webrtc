<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap5\Modal;
use common\models\UserProfile;
use common\models\ChatRepository;
use frontend\widgets\adminlte\Menu;
use common\widgets\chat\ChatBoxWidget;
use common\widgets\chat\ChatListWidget;


$profileId = Yii::$app->user->identity->userProfile->id;
$userProfiles = UserProfile::find()->where(['!=', 'user_id', Yii::$app->user->id])->all();
$this->registerJsVar('myToken', md5($profileId), View::POS_END);


$items = [];
$items[] = ['label' => 'Home', 'icon' => 'fas fa-home', 'url' => ['/']];
$items[] =  [
  'label' => 'Chat',
  'template' => '<a class="nav-link" href="{url}" data-bs-toggle="offcanvas" role="button" aria-controls="offcanvasRecentChat">{icon}{label}</a>',
  'url' => '#offcanvasRecentChat',
  'icon' => 'far fa-comments"',
  'visible' => !Yii::$app->user->isGuest,
];
$items[] = ['label' => 'Sets', 'icon' => 'fas fa-images', 'url' => ['/set/index'], 'visible' => !Yii::$app->user->isGuest,];

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
?>

<div class="offcanvas offcanvas-start m-0 p-0 position-relative min-h-100 d-none" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasMainMenu" aria-labelledby="offcanvasMainMenuLabel">
  <div class="offcanvas-header brand-container">
  <?= Html::a('<img class="brand-image img-circle elevation-3 opacity-80 shadow" width="50" href="javascript:;" src="' . ('/img/AdminLTELogo.png') . '" alt="APP">  <span class="brand-text font-weight-light">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'brand-link']) ?>
  <a class="pushmenu mx-1 rotate" id="btn-toggle-sidebar-mini" data-lte-toggle="sidebar-mini" href="javascript:;"  role="button"><i class="fas fa-angle-double-left"></i></a>
  </div>
  <div class="offcanvas-body h-100">
  <?= Menu::widget(
        [
          'options' => ['class' => 'nav nav-pills nav-sidebar flex-column', 'data-widget' => 'treeview'],
          'items' => $items,
        ]
      ) ?>
  </div>
</div>

<!-- Chat Section -->
<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasRecentChat" aria-labelledby="offcanvasRecentChatLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRecentChatLabel">Recent Chats</h5>
    <div class="btns">
      <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#newChat">
        <i class="fas fa-plus"></i>
      </button>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
  </div>
  <div class="offcanvas-body">
    <? Pjax::begin(['id' => 'left-chat-list']);     ?>

    <?=
    ChatListWidget::widget([
      'recentChat' => array_reverse(ChatRepository::getRecentChats($profileId)),
    ]);

    Pjax::end();
    ?>
  </div>
</div>

<?php
Modal::begin([
  'title' => 'New Chat ',
  'id' => 'newChat',
]);

echo ChatBoxWidget::widget([
  'users' => $userProfiles,
]);

Modal::end();

?>