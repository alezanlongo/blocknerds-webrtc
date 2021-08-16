<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000006_create_patient_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%patient_photo}}', [
            'id' => $this->primaryKey(),
            'contentType' => $this->string(),
            'language' => $this->string(),
            'data' => $this->string(),
            'uri' => $this->string(),
            'size' => $this->integer()->unsigned(),
            'hash' => $this->string(),
            'title' => $this->string(),
            'patient_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-patient_photo-patient_id',
            'patient_photo',
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
        $this->dropTable('{{%patient_photo}}');
    }
}
