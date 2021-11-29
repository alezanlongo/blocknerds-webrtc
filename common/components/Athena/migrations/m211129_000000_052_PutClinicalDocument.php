<?php

/**
 * Table for PutClinicalDocument
 */
class m211129_000000_052_PutClinicalDocument extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_clinical_documents}}', [
            'clinicalproviderid' => $this->integer(),
            'documenttypeid' => $this->integer(),
            'internalnote' => $this->string(),
            'observationdate' => $this->string(),
            'observationtime' => $this->string(),
            'priority' => $this->string(),
            'providerid' => $this->integer(),
            'replaceinternalnote' => $this->boolean(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_clinical_documents}}');
    }
}
