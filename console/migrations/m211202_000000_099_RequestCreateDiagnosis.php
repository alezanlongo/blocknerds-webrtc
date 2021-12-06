<?php

/**
 * Table for RequestCreateDiagnosis
 */
class m211202_000000_099_RequestCreateDiagnosis extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_create_diagnoses}}', [
            'icd10codes' => $this->string(),
            'icd9codes' => $this->string(),
            'laterality' => $this->string(),
            'note' => $this->string(),
            'snomedcode' => $this->integer()->notNull(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_create_diagnoses}}');
    }
}
