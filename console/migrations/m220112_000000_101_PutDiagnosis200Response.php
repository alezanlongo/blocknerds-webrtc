<?php

/**
 * Table for PutDiagnosis200Response
 */
class m220112_000000_101_PutDiagnosis200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_diagnosis200_responses}}', [
            'errormessage' => $this->string(),
            'success' => $this->string(),
            'supportslaterality' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_diagnosis200_responses}}');
    }
}
