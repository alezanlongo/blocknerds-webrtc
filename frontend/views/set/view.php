<?php

use common\widgets\gallery\GalleryWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;


$this->title = $model->title;
\yii\web\YiiAsset::register($this);
?>
<div class="set-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
         <?= Html::a('Add image', Url::to(['/unsplash', 'setId'=> $model->id]), ['class' => 'btn btn-success']) ?>
    </p>

    <?= GalleryWidget::widget([
        'photos' => $photos,
    ]);
    
    ?>

</div>
