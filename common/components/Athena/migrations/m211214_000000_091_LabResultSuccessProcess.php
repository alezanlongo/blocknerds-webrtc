<?php

/**
 * Table for LabResultSuccessProcess
 */
class m211214_000000_091_LabResultSuccessProcess extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%lab_result_success_processes}}', [
            'errormessage' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%lab_result_success_processes}}');
    }
}
