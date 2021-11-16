<?php

/**
 * Table for PutMedication200Response
 */
class m211115_000000_074_PutMedication200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_medication200_responses}}', [
            'errormessage' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_medication200_responses}}');
    }
}
