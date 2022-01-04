<?php

/**
 * Table for MedicationReference
 */
class m211222_000000_071_MedicationReference extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%medication_references}}', [
            'medication' => $this->string(),
            'medicationid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%medication_references}}');
    }
}
