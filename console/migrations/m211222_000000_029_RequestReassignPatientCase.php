<?php

/**
 * Table for RequestReassignPatientCase
 */
class m211222_000000_029_RequestReassignPatientCase extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_reassign_patient_cases}}', [
            'username' => $this->string()->notNull(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_reassign_patient_cases}}');
    }
}
