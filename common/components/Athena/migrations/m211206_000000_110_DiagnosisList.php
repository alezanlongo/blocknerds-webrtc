<?php

/**
 * Table for DiagnosisList
 */
class m211206_000000_110_DiagnosisList extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%diagnosis_lists}}', [
            'diagnosiscode' => $this->string(),
            'snomedicdcodes' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%diagnosis_lists}}');
    }
}
