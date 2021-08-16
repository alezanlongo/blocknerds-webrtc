<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000037_create_procedure_complication_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%procedure_complication}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'procedure_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-complication-procedure_id',
            'procedure_complication',
            'procedure_id',
            'procedure',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%procedure_complication}}');
    }
}
