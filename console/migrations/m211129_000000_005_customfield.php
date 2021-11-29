<?php

/**
 * Table for customfield
 */
class m211129_000000_005_customfield extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%customfields}}', [
            'customfieldid' => $this->string(),
            'customfieldvalue' => $this->string(),
            'optionid' => $this->string(),
            'patient_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-patient-patient_id',
            '{{%customfields}}',
            'patient_id',
            'patients',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%customfields}}');
    }
}
