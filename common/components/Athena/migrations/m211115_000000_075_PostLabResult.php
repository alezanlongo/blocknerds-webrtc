<?php

/**
 * Table for PostLabResult
 */
class m211115_000000_075_PostLabResult extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%post_lab_results}}', [
            'accessionid' => $this->string(),
            'analytes' => $this->string(),
            'attachmentcontents' => $this->string(),
            'attachmenttype' => $this->string(),
            'autoclose' => $this->boolean(),
            'departmentid' => $this->integer()->notNull(),
            'documenttypeid' => $this->integer(),
            'facilityid' => $this->integer(),
            'internalnote' => $this->string(),
            'interpretation' => $this->string(),
            'notetopatient' => $this->string(),
            'observationdate' => $this->string(),
            'observationtime' => $this->string(),
            'priority' => $this->string(),
            'providerid' => $this->integer(),
            'reportstatus' => $this->string(),
            'resultnotes' => $this->string(),
            'resultstatus' => $this->string(),
            'specimenreceiveddatetime' => $this->string(),
            'specimenreporteddatetime' => $this->string(),
            'tietoorderid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%post_lab_results}}');
    }
}
