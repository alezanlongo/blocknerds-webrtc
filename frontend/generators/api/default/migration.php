<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
?>
<?= '<?php' ?>

<?php if (isset($namespace)) {
    echo "\nnamespace $namespace;\n";
} ?>

/**
 * <?= $description ?>

 */
class <?= $className ?> extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('<?= $tableName ?>', [
<?php foreach ($attributes as $attribute): ?>
<?php if (!array_key_exists($attribute['name'], $relations)): ?>
            '<?= $attribute['dbName'] ?>' => <?= $attribute['dbType'] ?><?php if ($attribute['required']): ?>->notNull()<?php endif ?><?php if (isset($attribute['unique']) and $attribute['unique']): ?>->unique()<?php endif ?>,
<?php endif; ?>
<?php endforeach; ?>
<?php /*foreach ($relations as $relationName => $relation): ?>
<?php if ($relation['method'] == 'hasOne'): ?>
            '<?= $relation['link']['id'] ?>' => $this->integer(),
<?php endif; ?>
<?php endforeach;*/ ?>
        ]);

<?php foreach ($relations as $relationName => $relation): ?>
<?php if ($relation['method'] == 'hasOne'): ?>
        $this->addForeignKey(
            'fk-<?= $relationName ?>-<?= $relation['link']['id'] ?>',
            '<?= $tableName ?>',
            '<?= $relation['link']['id'] ?>',
            '<?= $tablesPrefix . Inflector::camel2id(StringHelper::basename(Inflector::pluralize($relation['class'])), '_') ?>',
            'id',
            'CASCADE'
        );
<?php endif; ?>
<?php endforeach; ?>
    }

    public function down()
    {
        $this->dropTable('<?= $tableName ?>');
    }
}
