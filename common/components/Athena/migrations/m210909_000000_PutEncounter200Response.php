<?php

/**
 * Table for PutEncounter200Response
 */
class m210909_000000_PutEncounter200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_encounter200_responses}}', [
            'errormessage' => text,
            'success' => text,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%put_encounter200_responses}}');
    }
}
