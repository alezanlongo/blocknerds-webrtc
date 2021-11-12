<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$size = 'small'


?>

<?php $form = ActiveForm::begin([
    'id' => 'unsplush-form',
    'options' => ['class' => 'form-inline'],
]) ?>
<?= $form->field($model, 'search') ?>

<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end() ?>

<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($photos as $photo) { ?>
        <div class="col">
            <div class="card">
                <img src="<?= $photo['urls'][$size] ?>" class="card-img-top" alt="">
                <div class="card-body">
                    <p class="card-text"><?= $photo['description'] ?? $photo['alt_description'] ?></p>
                    <form action="/photo/add" method="post" class="form-inline">
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?= $photo['id'] ?>">
                            <?= Html::dropDownList('set_id', null, ['' => "Select set"] + $collections, ['class' => 'form-control', 'required' => true]) ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add image</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php } ?>

</div>