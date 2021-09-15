<?php

/**
 * Table for Diagnoses
 */
class m210909_000000_Diagnoses extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%diagnoses}}', [
            'description' => text,
            'diagnosisid' => integer,
            'icdcodes' => text,
            'note' => text,
            'snomedcode' => integer,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%diagnoses}}');
    }
}
