<?php

use frontend\assets\users\UserProfileAsset;

use yii\helpers\BaseUrl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var \yii\web\View $this */
$this->registerJsFile("/js/mediaSelector.js");
?>
<hr class="border-bottom border-white">

<div class="container">
    <?php echo $this->registerJsVar('snapshootPreview', null); ?>
    <?php Pjax::begin(['id' => 'profile-image', 'enablePushState' => false]); ?>
    <?php $form = ActiveForm::begin(['id' => 'profile-image-form', 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'options' => ['data-pjax' => true]]) ?>
    <?php

    if ($imageFrom == 'camera' || $imageFrom == 'camera-preview') {
        echo $form->field($model, 'rawimage')->hiddenInput()->label(false);
        if ($imageFrom == 'camera') {
            $this->registerJs(
                <<<JS
            mediaSelector.setMediaDevice(document.getElementById("camera-preview"),false,true);
            JS,
                View::POS_END
            );
            echo '<video id="camera-preview" style="width:200px; height:200px; border: steelblue solid 1px;"></video>';
            echo '<canvas id="canvas-preview" class="d-none" style="width:200px; height:200px; border: steelblue solid 1px;"></canvas>';
            echo Html::a("Cancel", Url::current(['imageFrom' => null], false), ['class' => 'btn btn-danger', 'onclick' => "mediaSelector.stopAllStream();"]);
            echo Html::a("Snap shoot!", Url::current(['imageFrom' => 'camera-preview'], false), ['id' => 'snap-preview', 'class' => 'btn btn-primary', 'onclick' => "snapShoot(this);"]);
        } else {
            $this->registerJs(
                <<<JS
            snapShootPreview();
            JS,
                View::POS_END
            );
            echo '<canvas id="canvas-preview" class="" style="width:200px; height:200px; border: steelblue solid 1px;"></canvas>';
            echo Html::a("back", Url::current(['imageFrom' => 'camera'], false), ['class' => 'btn btn-warning']);
            echo Html::button("save", ['id' => 'snap-preview', 'class' => 'btn btn-primary', 'data-pjax' => 0, 'onclick' => "sendImage(this.form); return false"]);
        }
    }
    if ($imageFrom == 'file') {
        echo "<div id=\"image-preview\" style=\"overflow:hidden;width:200px; height:200px; border: steelblue solid 1px\"></div>";
        echo $form->field($model, 'image')->fileInput(['id' => 'image-selector', 'class' => 'input-image-profile', 'onchange' => 'filePreview(this)'])->label("Select file");
        echo Html::a("Cancel", Url::current(['imageFrom' => null], false), ['class' => 'btn btn-danger', 'onclick' => "mediaSelector.stopAllStream();"]);
        echo Html::button("save", ['id' => 'send-image', 'class' => 'btn btn-primary d-none', 'data-pjax' => 0, 'onclick' => "sendImage(this.form,'file'); return false"]);
    }
    if ($imageFrom === null) {
        echo Html::a("Camera", Url::current(['imageFrom' => 'camera']), ['class' => 'btn btn-primary']);
        echo Html::a("File", Url::current(['imageFrom' => 'file']), ['class' => 'btn btn-primary']);
    }
    ?>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
<script>
    const snapShoot = (elm) => {
        let vi = document.getElementById("camera-preview")
        let cv = document.getElementById("canvas-preview")

        cv.getContext("2d").drawImage(vi, 0, 0, cv.width, cv.height);
        snapshootPreview = cv.toDataURL('image/png');
    }
    const sendImage = (f, imgFrom = 'snapshoot') => {

        if (imgFrom == "snapshoot") {
            let fimg = f.querySelector("[name='<?php echo Html::getInputName($model, 'rawimage') ?>']")
            fimg.value = snapshootPreview;
            ajaxParams = {
                type: f.method,
                url: f.action,
                cache: false,
                data: $(f).serialize(),
                success: (r) => {
                    console.log("sent!")
                },
                error: (r) => {
                    console.log("error", r)
                }
            }
        } else {
            ajaxParams = {
                type: f.method,
                url: f.action,
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData(f),
                success: (r) => {
                    console.log("sent!")
                },
                error: (r) => {
                    console.log("error", r)
                }
            }

        }
        $.ajax(ajaxParams)
        snapshootPreview = null;
    }

    const snapShootPreview = () => {
        mediaSelector.stopAllStream();
        img = new Image();
        img.onload = () => {
            let cv = document.getElementById("canvas-preview")
            cv.getContext("2d").drawImage(img, 0, 0);
        }
        img.src = snapshootPreview;
    }

    const filePreview = (elm) => {
        let imgTypes = ["image/png", "image/jpg", "image/gif"];
        let si = document.getElementById("send-image");
        if (imgTypes.includes(elm.files[0].type)) {
            ip = document.getElementById("image-preview")
            ip.innerHTML = "";
            let img = new Image();
            img.src = URL.createObjectURL(elm.files[0])
            ip.appendChild(img)
            si.classList.remove("d-none");
        } else {
            if (!si.classList.contains("d-none")) {
                si.classList.add("d-none");
            }
        }
    }
</script>