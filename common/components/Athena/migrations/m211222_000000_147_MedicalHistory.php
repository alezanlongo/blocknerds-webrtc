<?php

/**
 * Table for MedicalHistory
 */
class m211222_000000_147_MedicalHistory extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%medical_histories}}', [
            'sectionnote' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%medical_histories}}');
    }
}
