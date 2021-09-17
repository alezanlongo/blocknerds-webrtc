<?php

/**
 * Table for Diagnoses
 */
class m210916_000000_Diagnoses extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%diagnoses}}', [
            'description' => $this->string(),
            'diagnosisid' => $this->integer(),
            'icdcodes' => $this->string(),
            'note' => $this->string(),
            'snomedcode' => $this->integer(),
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
