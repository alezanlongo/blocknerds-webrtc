<?php
use yii\helpers\Inflector;
use yii\helpers\VarDumper;

?>
<?= '<?php' ?>

namespace <?= $namespace ?>;

use yii\helpers\ArrayHelper;

/**
 * <?= str_replace("\n", "\n * ", trim($description)) ?>
 *
<?php foreach ($attributes as $attribute): ?>
 * @property <?= $attribute['type'] ?? 'mixed' ?> $<?= str_replace("\n", "\n * ", rtrim($attribute['name'] . ' ' . $attribute['description'])) ?>

<?php endforeach; ?>
 */
class <?= $className ?> extends \yii\db\ActiveRecord
{
<?php foreach ($attributes as $attribute): ?>
<?php if ( strpos($attribute['type'], '[]') !== false ): ?> 
    protected $_<?= $attribute['name'] ?>Ar;
<?php endif ?>
<?php endforeach; ?>

    public static function tableName()
    {
        return <?= var_export($tableName) ?>;
    }

    public function rules()
    {
        return [
<?php
    $safeAttributes = [];
    $requiredAttributes = [];
    $integerAttributes = [];
    $stringAttributes = [];

    foreach ($attributes as $attribute) {
        if ($attribute['readOnly']) {
            continue;
        }
        if ($attribute['required']) {
            $requiredAttributes[$attribute['name']] = $attribute['name'];
        }

        switch ($attribute['type']) {
            case 'int':
            case 'integer':
                $integerAttributes[$attribute['name']] = $attribute['name'];
                break;
            case 'string':
                $stringAttributes[$attribute['name']] = $attribute['name'];
                break;
            case 'bool':
            case 'boolean':
                $booleanAttributes[$attribute['name']] = $attribute['name'];
                break;
            default:
            case 'array':
                if( empty($attribute['flattened']) ) {
                    $safeAttributes[$attribute['name']] = $attribute['name'];
                }
                break;
        }
    }
    if (!empty($stringAttributes)) {
        echo "            [['" . implode("', '", $stringAttributes) . "'], 'trim'],\n";
    }
    if (!empty($requiredAttributes)) {
        echo "            [['" . implode("', '", $requiredAttributes) . "'], 'required'],\n";
    }
    if (!empty($stringAttributes)) {
        echo "            [['" . implode("', '", $stringAttributes) . "'], 'string'],\n";
    }
    if (!empty($integerAttributes)) {
        echo "            [['" . implode("', '", $integerAttributes) . "'], 'integer'],\n";
    }
    if (!empty($booleanAttributes)) {
        echo "            [['" . implode("', '", $booleanAttributes) . "'], 'boolean'],\n";
    }
    if (!empty($safeAttributes)) {
        echo "            // TODO define more concreate validation rules!\n";
        //echo "            [['" . implode("','", $safeAttributes) . "'], 'safe'],\n";//FIXME remove safe on flattened json
    }

?>
        ];
    }

<?php foreach ($relations as $relationName => $relation): ?>
    public function get<?= ucfirst($relationName) ?>()
    {
        return $this-><?= $relation['method'] ?>(<?= $relation['class'] ?>::class, <?php
            echo str_replace(
                    [',', '=>', ', ]'],
                    [', ', ' => ', ']'],
                    preg_replace('~\s+~', '', \yii\helpers\VarDumper::export($relation['link']))
            )
        ?>);
    }

<?php endforeach; ?>

    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

<?php foreach ($attributes as $attribute): ?>
        if($<?= $attribute['name'] ?> = ArrayHelper::getValue($apiObject, '<?= str_replace('__', '.', $attribute['flattenedField'] ?? $attribute['name']) ?>')) {
<?php 
        $fieldName = $attribute['name'];
        if ( strpos($attribute['type'], '[]') !== false ) {
            $fieldName = '_'.$fieldName.'Ar';
        }
?>
            $this-><?= $fieldName ?> = $<?= $attribute['name'] ?>;
        }
<?php if( $extIdField == $attribute['name'] ): ?>
        if($<?= $attribute['name'] ?> = ArrayHelper::getValue($apiObject, '<?= str_replace('__', '.', $attribute['name']) ?>')) {
            $this->externalId = $<?= $attribute['name'] ?>;
        }
<?php endif; ?>
<?php endforeach; ?>

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
    /* FIXME link doesn't work
    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);
<?php foreach($relations as $relationName => $relation): ?>
<?php if ($relation['method'] == 'hasMany'): ?>
        if( !empty($this->_<?= $relationName ?>Ar) and is_array($this->_<?= $relationName ?>Ar) ) {
            foreach($this->_<?= $relationName ?>Ar as $<?= $relationName ?>Api) {
                $<?= strtolower($relation['class']) ?> = new <?= $relation['class'] ?>();
                $<?= strtolower($relation['class']) ?>->loadApiObject($<?= $relationName ?>Api);
                $<?= strtolower($relation['class']) ?>->link('<?= Inflector::variablize($className) ?>', $this);
                $<?= strtolower($relation['class']) ?>->save();
            }
        }
<?php endif; ?>
<?php endforeach ?>

        return $saved;
    }
    */
}
