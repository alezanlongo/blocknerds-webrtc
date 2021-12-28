<?php

use Carbon\Carbon;
use common\models\Menu;
use common\models\Tree;
use kartik\base\Module;
use yii\console\widgets\Table;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\tree\TreeView;
use kartik\tree\TreeViewInput;


// $this->registerJsVar('logs', ArrayHelper::getColumn($logs, function ($element) {
//     return ['id' => $element['id'], 'sdp' => $element['sdp']];
// }), View::POS_END);
$this->registerJsFile('/js/iceLogMain.js', ['depends' => ["yii\web\JqueryAsset"], 'position' => View::POS_END]);

$this->title = 'Ice Event logs';
$profile = Yii::$app->user->identity->userProfile;
?>
<div class="spinner-border text-danger position-absolute top-50 start-50 d-none" id="spinnerLog" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
<div class="ice-event-log-index">
    <div class="d-flex justify-content-between">

        <h1><?= Html::encode($this->title) ?></h1>
        <!-- <?= Html::tag('button', "Refresh", ['class' => 'btn btn-success btn-refresh']) ?> -->

    </div>
    <?= TreeView::widget([
        // single query fetch to render the tree
        'query'             => Tree::find()->addOrderBy('root, lft'), 
        'headingOptions'    => ['label' => 'Logs'],
        'fontAwesome' => true,     // optional
        'isAdmin' => false,         // optional (toggle to enable admin mode)
        'displayValue' => 1,        // initial display value
        'softDelete' => true,       // defaults to true
        'cacheSettings' => [        
            'enableCache' => true   // defaults to true
        ],
        'nodeView' => '@frontend/views/ice-event/_details',
        'showFormButtons' => false,
        'allowNewRoots' => false,
        
    ]);
     ?>
     

</div>

<div class="modal fade" id="modalDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SDP details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5></h5>
                <p style="white-space: pre-wrap;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>