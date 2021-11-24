<?php

/**
 * Table for PutLabResultDataEntryComplete
 */
class m211118_000000_094_PutLabResultDataEntryComplete extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_lab_result_data_entry_completes}}', [
            'actionnote' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_lab_result_data_entry_completes}}');
    }
}
