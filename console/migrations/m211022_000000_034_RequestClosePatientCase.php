<?php

/**
 * Table for RequestClosePatientCase
 */
class m211022_000000_034_RequestClosePatientCase extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_close_patient_cases}}', [
            'actionreasonid' => $this->integer()->notNull(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_close_patient_cases}}');
    }
}
