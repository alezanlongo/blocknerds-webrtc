<?php

/**
 * Table for ObservationLabResult
 */
class m211222_000000_087_ObservationLabResult extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%observation_lab_results}}', [
            'labResult_id' => $this->integer(),
            'abnormalflag' => $this->string(),
            'analyteid' => $this->integer(),
            'analytename' => $this->string(),
            'loinc' => $this->string(),
            'note' => $this->string(),
            'observationidentifier' => $this->string(),
            'referencerange' => $this->string(),
            'resultstatus' => $this->string(),
            'units' => $this->string(),
            'value' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-labResult-labResult_id',
            '{{%observation_lab_results}}',
            'labResult_id',
            'lab_results',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%observation_lab_results}}');
    }
}
