<?php

/**
 * Table for PutInsuranceResponse
 */
class m211222_000000_105_PutInsuranceResponse extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_insurance_responses}}', [
            'message' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_insurance_responses}}');
    }
}
