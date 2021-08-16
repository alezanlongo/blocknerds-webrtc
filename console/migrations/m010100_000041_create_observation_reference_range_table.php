<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000041_create_observation_reference_range_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%observation_reference_range}}', [
            'id' => $this->primaryKey(),
            'low' => $this->string(),
            'high' => $this->string(),
            'meaning__coding' => $this->json(),
            'meaning__text' => $this->string(),
            'age__low' => $this->string(),
            'age__high' => $this->string(),
            'text' => $this->string(),
            'observation_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-reference_range-observation_id',
            'observation_reference_range',
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
        $this->dropTable('{{%observation_reference_range}}');
    }
}
