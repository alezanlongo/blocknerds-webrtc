<?php

/**
 * Table for Diagnoses
 */
class m211115_000000_016_Diagnoses extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%diagnoses}}', [
            'description' => $this->string(),
            'diagnosisid' => $this->integer(),
            'icdcodes' => $this->string(),
            'note' => $this->string(),
            'snomedcode' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%diagnoses}}');
    }
}
