<?php

/**
 * Table for VitalsResponse
 */
class m211028_000000_032_VitalsResponse extends \yii\db\Migration
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
