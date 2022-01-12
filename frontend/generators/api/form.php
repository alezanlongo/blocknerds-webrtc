<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator \cebe\yii2openapi\generator\ApiGenerator */

echo $form->field($generator, 'openApiPath')->error(['encode' => false]);
echo $form->field($generator, 'ignoreSpecErrors')->checkbox();
?>

<?= $form->field($generator, 'generateUrls')->hiddenInput(['value'=> 0])->label(false)?>
<?= $form->field($generator, 'generateControllers')->hiddenInput(['value'=> 0])->label(false)?>
<?= $form->field($generator, 'folderPath') ?>
<?= $form->field($generator, 'clientBaseClass') ?>


<?php

\cebe\yii2openapi\assets\BootstrapCardAsset::register($this);
$this->registerCss(
    <<<CSS
    /* bootstrap 4, Gii 2.1.x */
    .card-header .form-group,
    .card-header .form-group label,
    .card-header .form-group .help-block,
    /* bootstrap 3, Gii 2.0.x */
    .panel-heading .form-group,
    .panel-heading .form-group label,
    .panel-heading .form-group .help-block {
        margin-bottom: 0;
    }
CSS
);

$this->registerJs(
    <<<JS

    togglePanel = function() {
        $(this).parents('.panel').find('.panel-body input').prop('disabled', !this.checked);
        $(this).parents('.panel').find('.panel-body label').prop('disabled', !this.checked);
        if (this.checked) {
            $(this).parents('.panel').find('.panel-body').slideDown();
        } else {
            $(this).parents('.panel').find('.panel-body').slideUp();
        }
    };
    $('.panel-heading .form-group input[type=checkbox]').each(togglePanel);
    $('.panel-heading .form-group input[type=checkbox]').on('click', togglePanel);

JS
);
