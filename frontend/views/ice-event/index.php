<?php

use Carbon\Carbon;
use yii\console\widgets\Table;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\View;
$this->registerJsVar('logs', ArrayHelper::getColumn($logs, function ($element) {
    return ['id' =>$element['id'],'sdp' =>$element['sdp']];
}), View::POS_END);
$this->registerJsFile('/js/iceLogMain.js', ['depends' => ["yii\web\JqueryAsset"], 'position' => View::POS_END]);

$this->title = 'Ice Event logs';
$profile = Yii::$app->user->identity->userProfile;
// VarDumper::dump($logs, $depth = 10, $highlight = true);
// die;
?>

<div class="ice-event-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Create Ice Event Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Component Type</th>
                <th scope="col">Foundation</th>
                <th scope="col">Protocol</th>
                <th scope="col">Address</th>
                <th scope="col">Port</th>
                <th scope="col">Priority</th>
                <th scope="col">Mid</th>
                <th scope="col">MLine Index</th>
                <th scope="col">Username Fragment</th>
                <th scope="col">createdAt</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log) {
                $candidate = $log['ice']['candidate'];
            ?>
                <tr>
                    <th scope="row"><?= $log['id'] ?></th>
                    <td><?= $candidate['component'] ?></td>
                    <td><?= $candidate['foundation'] ?></td>
                    <td><?= $candidate['protocol'] ?></td>
                    <td><?= $candidate['address'] ?></td>
                    <td><?= $candidate['port'] ?></td>
                    <td><?= $candidate['priority'] ?></td>
                    <td><?= $candidate['sdpMid'] ?></td>
                    <td><?= $candidate['sdpMLineIndex'] ?></td>
                    <td><?= $candidate['usernameFragment'] ?></td>
                    <td><?= Carbon::createFromTimestamp($log['created_at'], $profile->timezone)->format('Y-m-d H:i:s') ?></td>
                    <td>
                        <button type="button" class="btn btn-primary btn-open-detail" data-id="<?= $log['id'] ?>" >
                            sdp Details
                        </button>
                    </td>
                </tr>
            <?php  } ?>
        </tbody>
    </table>


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