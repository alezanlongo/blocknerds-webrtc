<?php

/**
 * Table for EventDiagnose
 */
class m211206_000000_045_EventDiagnose extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%event_diagnoses}}', [
            'event_id' => $this->integer(),
            'code' => $this->string(),
            'codeset' => $this->string(),
            'name' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-event-event_id',
            '{{%event_diagnoses}}',
            'event_id',
            'events',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%event_diagnoses}}');
    }
}
