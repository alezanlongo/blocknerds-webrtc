<?php
/* @var $this yii\web\View */

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap5\Modal;
use yii\widgets\ActiveForm;
use frontend\assets\Fullcalendar\FullcalendarAsset;
use frontend\assets\Datetimepicker\DatetimepickerAsset;
use common\widgets\modalScheduleRoom\ModalScheduleRoomWidget;
use common\widgets\modalScheduledRoomOwner\ModalScheduledRoomOwnerWidget;
use common\widgets\modalScheduledRoomMember\ModalScheduledRoomMemberWidget;
use kartik\select2\Select2;
use yii\web\JsExpression;

DatetimepickerAsset::register($this);
FullcalendarAsset::register($this);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/appointmentSlotsCalendar.js',
    [
        'depends' => [
            "yii\web\JqueryAsset",
        ],
        'position' => View::POS_END
    ]
);

$this->registerJsVar('initialView', $initialView);
$this->registerJsVar('actionSlots', Yii::$app->getUrlManager()->createUrl('appointment/get-slots'));
$this->registerJsVar('actionBook', Yii::$app->getUrlManager()->createUrl('appointment/book-appointment'));

$this->title = "Appointment open slots";


?>

<div id="filters">
    <?php $form = ActiveForm::begin(['id' => 'appointment-filters']); ?>
    <?= $form->field($appointmentModel, 'departmentid')->dropdownList($departments,
        ['prompt'=>'Select department']
    );?>
    <?= $form->field($appointmentModel, 'providerid')->dropdownList($providers,
        ['prompt'=>'Select Provider']
    );?>

    <div class="form-group">
        <?= Html::submitButton('Apply filters', ['class' => 'btn btn-primary', 'name' => 'filter', 'id' => 'filter']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<div id="calendar" class="mt-5"></div>

<?php
    Modal::begin([
    'title' => 'Book appointment',
    'id' => 'bookappointment',
    ]);
    ?>
    <div class="row">
        <div class="col">
            <div class="">
                <?php $form = ActiveForm::begin(['id' => 'assign-patient-form']);
                echo Html::hiddenInput('patientId', '', ['id' => 'patientId']);
                echo Html::hiddenInput('appointmentid', '', ['id' => 'appointmentId']);
                ?>
                <?= $form->field($model, 'firstname')->widget(Select2::classname(), [
                    'options' => ['placeholder' => 'Search for a patient ...', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => '#bookappointment',
                        'minimumInputLength' => 2,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => \yii\helpers\Url::to(['patient/patients']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(firstname) { return firstname.fullname; }'),
                        'templateSelection' => new JsExpression("function (firstname) { $('#patientId').val(firstname.id); return firstname.fullname }"),
                    ],
                ]); ?>

                <div id="loading-overlay">
                    <div class="loading-icon"></div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Book appointment', ['class' => 'btn btn-primary', 'name' => 'book', 'id' => 'book']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>

<?php Modal::end(); ?>

<style>
    /*loader css*/

    #loading-overlay {
        position: absolute;
        width: 100%;
        height:100%;
        left: 0;
        top: 0;
        display: none;
        align-items: center;
        background-color: #000;
        z-index: 999;
        opacity: 0.5;
    }
    .loading-icon{ position:absolute;border-top:2px solid #fff;border-right:2px solid #fff;border-bottom:2px solid #fff;border-left:2px solid #767676;border-radius:25px;width:25px;height:25px;margin:0 auto;position:absolute;left:50%;margin-left:-20px;top:50%;margin-top:-20px;z-index:4;-webkit-animation:spin 1s linear infinite;-moz-animation:spin 1s linear infinite;animation:spin 1s linear infinite;}
    @-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
    @-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
    @keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }

</style>
