<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\bootstrap4\Modal;
use yii\bootstrap4\ButtonDropdown;
use kartik\select2\Select2;
use kartik\number\NumberControl;
use yii\web\JsExpression;
use common\models\User;

$this->registerJsFile(
    "https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.9/jquery.datetimepicker.full.min.js",
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);

$this->registerCssFile(
    "https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.9/jquery.datetimepicker.css"
);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/roomCreate.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);

$this->registerJsVar('roomMaxMembersAllowed', Yii::$app->params['janus.roomMaxMembersAllowed'], View::POS_END);

$this->title = 'Welcome to Room!';

?>
<div class="room-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
        ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
        fugiat nulla pariatur.</p>


    <?php $form = ActiveForm::begin(['action'=> 'room/create' ]); ?>
    <?= Html::submitButton("Start a quick meeting", ["class" => "btn btn-primary btn-lg", "id" => "btnStart"]) ?>
    <?= Html::a(
        "Planning a meeting",
        null,
        [
            'onclick' => "$('#planningMeeting').modal('show');return false;",
            "class" => "btn btn-outline-secondary btn-lg", "id" => "btnPlanning"
        ]
    ); ?>
    <?php ActiveForm::end(); ?>

</div><!-- room-create -->

<?
$form = ActiveForm::begin([
    'id' => 'formCreateSchedule',
]);

Modal::begin([
    'title' => 'Planning a meeting...',
    'id' => 'planningMeeting',
    'footer' => Html::submitButton('Create', ['class' => 'btn btn-primary', 'id' => 'btnCreateSchedule'])
]);

?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label class="control-label" for="title">Title</label>
                <?= Html::input('text', 'title', null, ['class' => 'form-control']) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col text-center">
            <p class="control-label text-left" for="datetimepicker">Date & time</p>
            <input type="text" name="datetimepicker" id="datetimepicker">
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label class="control-label" for="duration">Duration</label>
                <?
                $items = [
                    '900' => '15 minutes',
                    '1800' => '30 minutes',
                    '3600' => '1 hour',
                    '5400' => '1 hour and 30 minutes',
                    '7200' => '2 hours'
                ];

                echo Html::dropDownList(
                    'duration',
                    null,
                    $items,
                    ['class' => 'form-control', 'prompt' => 'Select duration'],
                );
                ?>
            </div>
        </div>
    </div>

    <?
    echo $form->field(new User, 'username')->widget(Select2::class, [
        'options' => ['multiple' => true, 'placeholder' => 'Search for a user ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 2,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => \yii\helpers\Url::to(['user-list']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(user) { return user.username; }'),
            'templateSelection' => new JsExpression('function (user) { return user.username; }'),
        ],
    ]);
    ?>
</div>
<?
Modal::end();

ActiveForm::end();

Modal::begin([
    'title' => 'Planning a meeting...',
    'id' => 'planningMeetingSuccessfully',
]);
Modal::end();
?>