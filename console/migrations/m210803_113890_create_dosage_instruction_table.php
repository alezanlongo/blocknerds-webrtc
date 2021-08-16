<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dosage_instruction}}`.
 */
class m210803_113890_create_dosage_instruction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dosage_instruction}}', [
            'id' => $this->primaryKey(),
            'dosequantity__code' => $this->string(),
            'dosequantity__system' => $this->string(),
            'dosequantity__unit' => $this->string(),
            'dosequantity__value' => $this->integer(),
            'text' => $this->string(),
            'timing__event' => $this->json(),
            'timing__repeat__frequency' => $this->integer(),
            'timing__repeat__period' => $this->string(),
            'timing__repeat__periodunits' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dosage_instruction}}');
    }
}
