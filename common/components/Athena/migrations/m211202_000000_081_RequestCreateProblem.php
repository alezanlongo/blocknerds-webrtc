<?php

/**
 * Table for RequestCreateProblem
 */
class m211202_000000_081_RequestCreateProblem extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_create_problems}}', [
            'PATIENTFACINGCALL' => $this->boolean(),
            'THIRDPARTYUSERNAME' => $this->string(),
            'departmentid' => $this->integer()->notNull(),
            'laterality' => $this->string(),
            'note' => $this->string(),
            'snomedcode' => $this->integer()->notNull(),
            'startdate' => $this->string(),
            'status' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_create_problems}}');
    }
}
