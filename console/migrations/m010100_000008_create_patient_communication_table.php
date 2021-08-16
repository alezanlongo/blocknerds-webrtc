<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000008_create_patient_communication_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%patient_communication}}', [
            'id' => $this->primaryKey(),
            'language__coding' => $this->json(),
            'language__text' => $this->string(),
            'prefered' => $this->boolean(),
            'patient_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-patient_communication-patient_id',
            'patient_communication',
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
        $this->dropTable('{{%patient_communication}}');
    }
}
