<?php

use frontend\assets\adminlte\AdminLteAsset;
use frontend\assets\AppAsset;
use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $content */

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
</head>

<body class="login-page ">
    <?php $this->beginBody() ?>

    <?= $content ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>