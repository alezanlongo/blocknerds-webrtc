<?php

use frontend\controllers\UnsplashController;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$size = UnsplashController::SIZE_IMAGE_DEFAULT;

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/unsplush.js',
    [
        'depends' => [
            "yii\web\JqueryAsset",
        ],
        'position' => View::POS_END
    ]
);
?>

<?php $form = ActiveForm::begin([
    'id' => 'unsplush-form',
    'options' => ['class' => 'form-inline'],
]) ?>
<?= $form->field($model, 'search') ?>

<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end() ?>

<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($photos as $key => $photo) { ?>
        <div class="col">
            <div class="card">
                <?= Html::img($photo['urls'][$size], ['class' => 'card-img-top', 'alt' => "image"]) ?>
                <div class="card-body">
                    <?= Html::tag('p', $photo['description'] ?? $photo['alt_description'], ['class' => 'card-text']) ?>
                    <?= Html::beginForm('photo/add', 'POST', ['id' => "form-add-photo-$key"]) ?>
                    <?= Html::hiddenInput("photo_id", $photo['id']) ?>
                    <?= Html::hiddenInput("size_image_default", $size) ?>

                    <div class="form-group">
                        <?= Html::dropDownList('set_id', $collections[0] ?? null, $collections, ['class' => 'form-control', 'required' => true]) ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Add image', ['class' => 'btn btn-primary btn-add-photo', 'data-key' => $key]) ?>
                    </div>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>

    <?php } ?>

</div>