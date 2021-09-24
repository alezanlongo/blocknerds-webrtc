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
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('<?= $tableName ?>');
    }
}
