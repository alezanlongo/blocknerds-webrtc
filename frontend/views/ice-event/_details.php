<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015 - 2019
 * @package   yii2-tree-manager
 * @version   1.1.3
 */

use Carbon\Carbon;
use common\models\IceEventLog;
use common\models\Room;
use kartik\form\ActiveForm;
use kartik\tree\Module;
use kartik\tree\TreeView;
use kartik\tree\models\Tree;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\View;

/**
 * @var View $this
 * @var Tree $node
 * @var ActiveForm $form
 * @var array $formOptions
 * @var string $keyAttribute
 * @var string $nameAttribute
 * @var string $iconAttribute
 * @var string $iconTypeAttribute
 * @var string $iconsListShow
 * @var array|null $iconsList
 * @var string $formAction
 * @var array $breadcrumbs
 * @var array $nodeAddlViews
 * @var mixed $currUrl
 * @var boolean $isAdmin
 * @var boolean $showIDAttribute
 * @var boolean $showNameAttribute
 * @var boolean $showFormButtons
 * @var boolean $allowNewRoots
 * @var string $nodeSelected
 * @var string $nodeTitle
 * @var string $nodeTitlePlural
 * @var array $params
 * @var string $keyField
 * @var string $nodeView
 * @var string $nodeAddlViews
 * @var array $nodeViewButtonLabels
 * @var string $noNodesMessage
 * @var boolean $softDelete
 * @var string $modelClass
 * @var string $defaultBtnCss
 * @var string $treeManageHash
 * @var string $treeSaveHash
 * @var string $treeRemoveHash
 * @var string $treeMoveHash
 * @var string $hideCssClass
 */
?>

<?php
/**
 * SECTION 1: Initialize node view params & setup helper methods.
 */
?>
<?php
extract($params);
$session = Yii::$app->has('session') ? Yii::$app->session : null;
const LEVEL_ROOM = 0;
const LEVEL_PROFILE = 1;
const LEVEL_LOG = 2;

// parse parent key
if ($node->isNewRecord) {
    $parentKey = empty($parentKey) ? '' : $parentKey;
} elseif (empty($parentKey)) {
    $parent = $node->parents(1)->one();
    $parentKey = empty($parent) ? '' : Html::getAttributeValue($parent, $keyAttribute);
}
$data = null;
switch ($node->lvl) {
    case LEVEL_ROOM:
        $room = Room::findOne(['uuid' => $node->name]);
        if ($room) {
            $data = $room->roomMembers;
        }
        break;
    case LEVEL_PROFILE:
        $data = array_map(function ($treeLog) {
            $log = $treeLog->log;
            $roomMember = $log->roomMember;
            return [
                'id' => $log->id,
                'candidate' => $log->log['candidate'],
                'created_at' => $log->created_at,
                'profile' => [
                    'id' => $log->profile_id,
                    'username' => $roomMember->userProfile->user->username,
                    'room_uuid' => $roomMember->room->uuid,
                ],
            ];
        }, $node->children()->all());
        break;
    case LEVEL_LOG:
        // $data = $node->log;
        // $data = IceEventLog::findOne($node->ice_event_log_id) ;
        // VarDumper::dump( $data, $depth = 10, $highlight = true);
        // die;
        $data = 4;

        break;
    default:
        break;
}

/** @var Module $module */
$module = TreeView::module();

// active form instance
$form = ActiveForm::begin(['action' => $formAction, 'options' => $formOptions]);

// helper function to show alert
$showAlert = function ($type, $body = '', $hide = true) use ($hideCssClass) {
    $class = "alert alert-{$type}";
    if ($hide) {
        $class .= ' ' . $hideCssClass;
    }
    return Html::tag('div', '<div>' . $body . '</div>', ['class' => $class]);
};

// helper function to render additional view content
$renderContent = function ($part) use ($nodeAddlViews, $params, $form) {
    if (empty($nodeAddlViews[$part])) {
        return '';
    }
    $p = $params;
    $p['form'] = null;
    return $this->render($nodeAddlViews[$part], $p);
};

?>

<?= Html::hiddenInput('nodeTitle', $nodeTitle) ?>
<?= Html::hiddenInput('nodeTitlePlural', $nodeTitlePlural) ?>
<?= Html::hiddenInput('treeNodeModify', $node->isNewRecord) ?>
<?= Html::hiddenInput('parentKey', $parentKey) ?>
<?= Html::hiddenInput('currUrl', $currUrl) ?>
<?= Html::hiddenInput('modelClass', $modelClass) ?>
<?= Html::hiddenInput('nodeSelected', $nodeSelected) ?>

<?php
/**
 * SECTION 3: Hash signatures to prevent data tampering. In case you are extending this and creating your own view, it
 * is mandatory to include this section below.
 */
?>
<?= Html::hiddenInput('treeManageHash', $treeManageHash) ?>
<?= Html::hiddenInput('treeRemoveHash', $treeRemoveHash) ?>
<?= Html::hiddenInput('treeMoveHash', $treeMoveHash) ?>
<?php
/**
 * BEGIN VALID NODE DISPLAY
 */
?>
<?php if (!$node->isNewRecord || !empty($parentKey)) : ?>
    <?php
    $cbxOptions = ['custom' => true];                           // default checkbox/ radio options (useful for BS4)
    $isAdmin = ($isAdmin == true || $isAdmin === "true");       // admin mode flag
    $inputOpts = [];                                            // readonly/disabled input options for node
    $flagOptions = $cbxOptions + ['class' => 'kv-parent-flag']; // node options for parent/child

    /**
     * the primary key input field
     */
    if ($showIDAttribute) {
        $options = ['readonly' => true];
        if ($node->isNewRecord) {
            $options['value'] = Yii::t('kvtree', '(new)');
        }
        $keyField = $form->field($node, $keyAttribute)->textInput($options);
    } else {
        $keyField = Html::activeHiddenInput($node, $keyAttribute);
    }

    if ($node->isReadonly()) {
        $inputOpts['readonly'] = true;
    }
    if ($node->isDisabled()) {
        $inputOpts['disabled'] = true;
    }
    if ($node->isLeaf()) {
        $flagOptions['disabled'] = true;
    }
    ?>
    <?php
    if (!empty($data)) {
        switch ($node->lvl) {
            case LEVEL_ROOM:
                echo Html::tag('p', 'Room name: ' . $node->name);
                echo Html::tag('p', 'List of participants: '); ?>
                <ul class="list-group list-group-flush">
                    <?php
                    foreach ($data as $member) {
                        echo Html::tag('li', $member->userProfile->user->username, ['class' => 'list-group-item']);
                    } ?>
                </ul>
            <?php
                break;
            case LEVEL_PROFILE:  ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Component</th>
                            <th scope="col">Type</th>
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
                        <?php foreach ($data as $log) {
                            $candidate = $log['candidate'];
                        ?>
                            <tr>
                                <th scope="row"><?= $log['id'] ?></th>
                                <td><?= $candidate['component'] ?></td>
                                <td><?= $candidate['type'] ?></td>
                                <td><?= $candidate['foundation'] ?></td>
                                <td><?= $candidate['protocol'] ?></td>
                                <td><?= $candidate['address'] ?></td>
                                <td><?= $candidate['port'] ?></td>
                                <td><?= $candidate['priority'] ?></td>
                                <td><?= $candidate['sdpMid'] ?></td>
                                <td><?= $candidate['sdpMLineIndex'] ?></td>
                                <td><?= $candidate['usernameFragment'] ?></td>
                                <td><?= Carbon::createFromTimestamp($log['created_at'])->format('Y-m-d H:i:s') ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-open-detail" onclick="openModal(<?= $log['id'] ?>)">
                                        sdp Details
                                    </button>
                                </td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            <?php
                break;
            case LEVEL_LOG:
                // VarDumper::dump( , $depth = 10, $highlight = true);
                // die;
                echo Html::tag('h1', 'Get details on parent node');
            ?>
    <?php
                break;
        }
    } else {
        echo Html::tag('h1', 'Nothing to show');
    }
    ?>
    <? $renderContent(Module::VIEW_PART_2) ?>


    <?php
    /**
     * SECTION 13: Additional views part 5 accessible by all users after admin zone.
     */
    ?>
    <? $renderContent(Module::VIEW_PART_5) ?>
<?php else : ?>
    <?= $noNodesMessage ?>
<?php endif; ?>
<?php
/**
 * END VALID NODE DISPLAY
 */
?>
<?php ActiveForm::end(); ?>