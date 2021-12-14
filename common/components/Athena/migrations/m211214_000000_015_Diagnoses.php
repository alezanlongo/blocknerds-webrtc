<?php

/**
 * Table for Diagnoses
 */
class m211214_000000_015_Diagnoses extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%diagnoses}}', [
            'description' => $this->string(),
            'diagnosisid' => $this->integer(),
            'errormessage' => $this->string(),
            'laterality' => $this->string(),
            'note' => $this->string(),
            'ranking' => $this->integer(),
            'snomedcode' => $this->integer(),
            'success' => $this->string(),
            'supportslaterality' => $this->string(),
            'encounter_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-encounter-encounter_id',
            '{{%diagnoses}}',
            'encounter_id',
            'encounters',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%diagnoses}}');
    }
}
