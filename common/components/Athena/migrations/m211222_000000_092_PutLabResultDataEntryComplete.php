<?php

/**
 * Table for PutLabResultDataEntryComplete
 */
class m211222_000000_092_PutLabResultDataEntryComplete extends \yii\db\Migration
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
