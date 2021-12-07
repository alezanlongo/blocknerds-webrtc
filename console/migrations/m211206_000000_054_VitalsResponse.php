<?php

/**
 * Table for VitalsResponse
 */
class m211206_000000_054_VitalsResponse extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%vitals_responses}}', [
            'errormessage' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%vitals_responses}}');
    }
}
