<?php

/**
 * Table for LabResult200Response
 */
class m211129_000000_090_LabResult200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%lab_result200_responses}}', [
            'errormessage' => $this->string(),
            'labresultid' => $this->integer(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%lab_result200_responses}}');
    }
}
