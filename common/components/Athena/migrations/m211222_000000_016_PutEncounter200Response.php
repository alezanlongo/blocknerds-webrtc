<?php

/**
 * Table for PutEncounter200Response
 */
class m211222_000000_016_PutEncounter200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_encounter200_responses}}', [
            'errormessage' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_encounter200_responses}}');
    }
}
