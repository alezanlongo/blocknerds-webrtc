<?php

/**
 * Table for EventDiagnose
 */
class m211115_000000_047_EventDiagnose extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%event_diagnoses}}', [
            'code' => $this->string(),
            'codeset' => $this->string(),
            'name' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%event_diagnoses}}');
    }
}
