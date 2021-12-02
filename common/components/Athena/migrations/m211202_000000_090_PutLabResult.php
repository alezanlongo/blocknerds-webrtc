<?php

/**
 * Table for PutLabResult
 */
class m211202_000000_090_PutLabResult extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_lab_results}}', [
            'accessionid' => $this->string(),
            'analytes' => $this->string(),
            'documenttypeid' => $this->integer(),
            'facilityid' => $this->integer(),
            'internalnote' => $this->string(),
            'interpretation' => $this->string(),
            'notetopatient' => $this->string(),
            'observationdate' => $this->string(),
            'observationtime' => $this->string(),
            'priority' => $this->string(),
            'providerid' => $this->integer(),
            'replaceinternalnote' => $this->boolean(),
            'replacepatientnote' => $this->boolean(),
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
        $this->dropTable('{{%put_lab_results}}');
    }
}
