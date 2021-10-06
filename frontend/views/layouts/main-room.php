<?php

use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $content */

dmstr\adminlte\web\AdminLteAsset::register($this);
dmstr\adminlte\web\FontAwesomeAsset::register($this);
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

<body class="login-page dark-mode" >
    <?php $this->beginBody() ?>

        <?= $content ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>