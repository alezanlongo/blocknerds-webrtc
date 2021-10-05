<?php

/**
 * Table for RequestCreatePatientCase
 */
class m211005_000000_023_RequestCreatePatientCase extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_create_patient_cases}}', [
            'autoclose' => $this->boolean(),
            'callbackname' => $this->string(),
            'callbacknumber' => $this->string(),
            'callbacknumbertype' => $this->string(),
            'clinicalproviderid' => $this->integer(),
            'departmentid' => $this->integer()->notNull(),
            'documentsource' => $this->string()->notNull(),
            'documentsubclass' => $this->string()->notNull(),
            'internalnote' => $this->string(),
            'outboundonly' => $this->boolean(),
            'priority' => $this->string(),
            'providerid' => $this->integer()->notNull(),
            'subject' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_create_patient_cases}}');
    }
}
