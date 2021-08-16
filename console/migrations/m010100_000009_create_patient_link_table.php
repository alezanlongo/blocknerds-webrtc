<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000009_create_patient_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%patient_link}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
            'other__display' => $this->string(),
            'other__reference' => $this->string(),
            'patient_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-patient_link-patient_id',
            'patient_link',
            'patient_id',
            'patient',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%patient_link}}');
    }
}
