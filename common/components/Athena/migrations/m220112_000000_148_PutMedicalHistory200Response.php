<?php

/**
 * Table for PutMedicalHistory200Response
 */
class m220112_000000_148_PutMedicalHistory200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_medical_history200_responses}}', [
            'errormessage' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_medical_history200_responses}}');
    }
}
