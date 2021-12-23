<?php
/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015 - 2019
 * @package   yii2-tree-manager
 * @version   1.1.3
 */

use Carbon\Carbon;
use common\models\IceEventLog;
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
$resetTitle = Yii::t('kvtree', 'Reset');
$submitTitle = Yii::t('kvtree', 'Save');

// parse parent key
if ($node->isNewRecord) {
    $parentKey = empty($parentKey) ? '' : $parentKey;
} elseif (empty($parentKey)) {
    $parent = $node->parents(1)->one();
    $parentKey = empty($parent) ? '' : Html::getAttributeValue($parent, $keyAttribute);
}
$isLvlOne = $node->lvl === 0;

if($isLvlOne){
    $ids = ArrayHelper::getColumn($node->children()->all(),'id');
    $logs = IceEventLog::find()->where(['in', 'id', $ids])->all();
    $logs = array_map(function ($log) {
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
    }, $logs);
}

/** @var Module $module */
$module = TreeView::module();

// active form instance
$form = ActiveForm::begin(['action' => $formAction, 'options' => $formOptions]);

// helper function to show alert
$showAlert = function ($type, $body = '', $hide = true) use($hideCssClass) {
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

// node identifier
// $id = $node->isNewRecord ? null : $node->$keyAttribute;
// // breadcrumbs
// if (array_key_exists('depth', $breadcrumbs) && $breadcrumbs['depth'] === null) {
//     $breadcrumbs['depth'] = '';
// } elseif (!empty($breadcrumbs['depth'])) {
//     $breadcrumbs['depth'] = (string)$breadcrumbs['depth'];
// }
// // icons list
// $icons = is_array($iconsList) ? array_values($iconsList) : $iconsList;
?>

<?php
/**
 * SECTION 2: Initialize hidden attributes. In case you are extending this and creating your own view, it is mandatory
 * to set all these hidden inputs as defined below.
 */
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
<?php if (!$node->isNewRecord || !empty($parentKey)): ?>
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

    /**
     * initialize for create or update
     */
    // $depth = ArrayHelper::getValue($breadcrumbs, 'depth', '');
    // $glue = ArrayHelper::getValue($breadcrumbs, 'glue', '');
    // $activeCss = ArrayHelper::getValue($breadcrumbs, 'activeCss', '');
    // $untitled = ArrayHelper::getValue($breadcrumbs, 'untitled', '');
    // $name = $node->getBreadcrumbs($depth, $glue, $activeCss, $untitled);
    // if ($node->isNewRecord && !empty($parentKey) && $parentKey !== TreeView::ROOT_KEY) {
    //     /**
    //      * @var Tree $modelClass
    //      * @var Tree $parent
    //      */
    //     if (empty($depth)) {
    //         $depth = null;
    //     }
    //     if ($depth === null || $depth > 0) {
    //         $parent = $modelClass::findOne($parentKey);
    //         $name = $parent->getBreadcrumbs($depth, $glue, null) . $glue . $name;
    //     }
    // }
    if ($node->isReadonly()) {
        $inputOpts['readonly'] = true;
    }
    if ($node->isDisabled()) {
        $inputOpts['disabled'] = true;
    }
    if ($node->isLeaf()) {
        $flagOptions['disabled'] = true;
    }

    // $nameField = $showNameAttribute ? $form->field($node, $nameAttribute)->textInput($inputOpts) : '';
    ?>
 
    <?php
    /**
     * SECTION 6: Additional views part 1 - before all form attributes.
     */
    ?>
    <?php
    // VarDumper::dump( $node, $depth = 10, $highlight = true);
    // die;
    //  $renderContent(Module::VIEW_PART_1);
    ?>

    <?php
    /**
     * SECTION 7: Basic node attributes for editing.
     */
    ?>

    <?php if($isLvlOne): ?>
        <!-- show children -->
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
            <?php foreach ($logs as $log) {
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
                        <button type="button" class="btn btn-primary btn-open-detail" onclick="openModal(<?= $log['id'] ?>)" >
                            sdp Details
                        </button>
                    </td>
                </tr>
            <?php  } ?>
        </tbody>
    </table>
    <?php else: ?>
        <h1>Nothing to show</h1>
    <?php endif ?>
   

    <?php
    /**
     * SECTION 8: Additional views part 2 - before admin zone.
     */
    ?>
    <? $renderContent(Module::VIEW_PART_2) ?>

    
    <?php
    /**
     * SECTION 13: Additional views part 5 accessible by all users after admin zone.
     */
    ?>
    <? $renderContent(Module::VIEW_PART_5) ?>
<?php else: ?>
    <?= $noNodesMessage ?>
<?php endif; ?>
<?php
/**
 * END VALID NODE DISPLAY
 */
?>
<?php ActiveForm::end(); ?>