<?php

/**
 * Table for DeleteInsuranceResponse
 */
class m211214_000000_106_DeleteInsuranceResponse extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%delete_insurance_responses}}', [
            'message' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%delete_insurance_responses}}');
    }
}
