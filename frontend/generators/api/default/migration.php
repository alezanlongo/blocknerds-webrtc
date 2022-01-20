<?php
use yii\helpers\Inflector;
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
        $this->createTable('<?= $tablesPrefix.$tableName ?>', [
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
            '<?= Inflector::tableize($relationName) ?>',
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
