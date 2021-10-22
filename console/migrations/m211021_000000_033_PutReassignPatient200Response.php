<?php

/**
 * Table for PutReassignPatient200Response
 */
class m211021_000000_033_PutReassignPatient200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_reassign_patient200_responses}}', [
            'assignedto' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_reassign_patient200_responses}}');
    }
}