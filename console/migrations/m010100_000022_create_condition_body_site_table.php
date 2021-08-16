<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000022_create_condition_body_site_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%condition_body_site}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->string(),
            'text' => $this->json(),
            'condition_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-body_site-condition_id',
            'condition_body_site',
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
        $this->dropTable('{{%condition_body_site}}');
    }
}
