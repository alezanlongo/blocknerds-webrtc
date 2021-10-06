<?php

/** @var \yii\web\View $this */

use yii\helpers\Url;
use yii\helpers\VarDumper;

/** @var string $directoryAsset */

$items = [];
$items[] = ['label' => 'Home', 'icon' => 'fas fa-home', 'url' => ['/']];

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

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?= \yii\helpers\Html::a('<img class="brand-image img-circle elevation-3" src="' . ($directoryAsset . '/img/AdminLTELogo.png') . '" alt="APP"><span class="brand-text font-weight-light">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'brand-link']) ?>
    <div class="sidebar">

        <nav class="mt-2">
            <?= dmstr\adminlte\widgets\Menu::widget(
                [
                    'options' => ['class' => 'nav nav-pills nav-sidebar flex-column', 'data-widget' => 'treeview'],
                    'items' => $items,
                ]
            ) ?>
        </nav>

    </div>

</aside>