<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000021_create_condition_evidence_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%condition_evidence}}', [
            'id' => $this->primaryKey(),
            'code__coding' => $this->string(),
            'code__text' => $this->json(),
            'condition_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-evidence-condition_id',
            'condition_evidence',
            'condition_id',
            'condition',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%condition_evidence}}');
    }
}
