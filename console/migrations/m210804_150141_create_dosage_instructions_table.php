<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dosage_instructions}}`.
 */
class m210804_150141_create_dosage_instructions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dosage_instructions}}', [
            'id' => $this->primaryKey(),
            'additionalinstructions__coding' => $this->json(),
            'additionalinstructions__text' => $this->string(),
            'text' => $this->string(),
            'timing__event' => $this->json(),
            'timing__repeat__frequency' => $this->integer(),
            'timing__repeat__period' => $this->integer(),
            'timing__repeat__periodunits' => $this->string(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dosage_instructions}}');
    }
}
