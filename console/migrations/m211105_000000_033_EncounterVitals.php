<?php

/**
 * Table for EncounterVitals
 */
class m211105_000000_033_EncounterVitals extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%encounter_vitals}}', [
            'encounter_id' => $this->integer(),
            'posting' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-encounter-encounter_id',
            '{{%encounter_vitals}}',
            'encounter_id',
            'encounters',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%encounter_vitals}}');
    }
}
