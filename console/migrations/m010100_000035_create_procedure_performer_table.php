<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000035_create_procedure_performer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%procedure_performer}}', [
            'id' => $this->primaryKey(),
            'role__coding' => $this->json(),
            'role__text' => $this->string(),
            'procedure_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-performer-procedure_id',
            'procedure_performer',
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
        $this->dropTable('{{%procedure_performer}}');
    }
}
