<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000042_create_observation_related_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%observation_related}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
            'observation_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-related-observation_id',
            'observation_related',
            'observation_id',
            'observation',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%observation_related}}');
    }
}
