<?php

/**
 * Table for RequestCreateMedication
 */
class m211118_000000_070_RequestCreateMedication extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_create_medications}}', [
            'PATIENTFACINGCALL' => $this->boolean(),
            'THIRDPARTYUSERNAME' => $this->string(),
            'departmentid' => $this->integer()->notNull(),
            'hidden' => $this->boolean(),
            'medicationid' => $this->integer()->notNull(),
            'patientnote' => $this->string(),
            'providernote' => $this->string(),
            'startdate' => $this->string(),
            'stopdate' => $this->string(),
            'stopreason' => $this->string(),
            'unstructuredsig' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_create_medications}}');
    }
}
