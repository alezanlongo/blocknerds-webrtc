<?php

/**
 * Table for PutMedicalHistory
 */
class m211222_000000_149_PutMedicalHistory extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_medical_histories}}', [
            'departmentid' => $this->integer()->notNull(),
            'sectionnote' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_medical_histories}}');
    }
}
