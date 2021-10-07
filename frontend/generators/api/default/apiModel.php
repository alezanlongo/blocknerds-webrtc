<?= '<?php' ?>


namespace <?= $namespace ?>;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * <?= str_replace("\n", "\n * ", trim($description)) ?>

 *
<?php foreach ($attributes as $attribute): ?>
 * @property <?= $attribute['type'] ?? 'mixed' ?> $<?= str_replace("\n", "\n * ", rtrim($attribute['name'] . ' ' . $attribute['description'])) ?>

<?php endforeach; ?>
 */
class <?= $className ?> extends BaseApiModel
{

<?php foreach ($attributes as $attribute): ?>
    public $<?= $attribute['name'] ?>;
<?php if ( strpos($attribute['type'], '[]') !== false ): ?> 
    protected $_<?= $attribute['name'] ?>Ar;
<?php endif ?>
<?php endforeach; ?>

    public function rules()
    {
        return [
<?php
    $requiredAttributes = [];
    $integerAttributes = [];
    $stringAttributes = [];
    foreach ($attributes as $attribute) {
        if ($attribute['required']) {
            $requiredAttributes[$attribute['name']] = $attribute['name'];
        }
        switch ($attribute['type']) {
            case 'integer':
                $integerAttributes[$attribute['name']] = $attribute['name'];
                break;
            case 'string':
                $stringAttributes[$attribute['name']] = $attribute['name'];
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

?>
        ];
    }
<?php /* IMPROVEME check if any attrib is array first? */ ?>
    public function init()
    {
        parent::init();
<?php
    foreach ($attributes as $attribute) { 
        if (strpos($attribute['type'], '[]') !== false) {
?>
        if (!empty($this-><?= $attribute['name'] ?>) && is_array($this-><?= $attribute['name'] ?>)) {
            foreach($this-><?= $attribute['name'] ?> as $<?= $attribute['name'] ?>) {
                $this->_<?= $attribute['name'] ?>Ar[] = new <?= str_replace('[]', '', $attribute['type'].'Api') ?>($<?= $attribute['name'] ?>);
            }
            $this-><?= $attribute['name'] ?> = $this->_<?= $attribute['name'] ?>Ar;
            $this->_<?= $attribute['name'] ?>Ar = [];//CHECKME
        }
<?php
        }//-foreach
    }//-if
?>
    }

}
