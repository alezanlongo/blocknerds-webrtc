<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000034_create_procedure_body_site_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%procedure_body_site}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'procedure_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-body_site-procedure_id',
            'procedure_body_site',
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
        $this->dropTable('{{%procedure_body_site}}');
    }
}
