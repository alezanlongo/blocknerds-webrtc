<?php

/**
 * Table for PatientCaseChanged
 */
class m211118_000000_030_PatientCaseChanged extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%patient_case_changeds}}', [
            'totalcount' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%patient_case_changeds}}');
    }
}