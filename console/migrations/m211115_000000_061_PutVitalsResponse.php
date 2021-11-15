<?php

/**
 * Table for PutVitalsResponse
 */
class m211115_000000_061_PutVitalsResponse extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_vitals_responses}}', [
            'errormessage' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_vitals_responses}}');
    }
}
