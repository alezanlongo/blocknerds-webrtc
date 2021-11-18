<?php

/**
 * Table for PostClinicalDocument
 */
class m211118_000000_049_PostClinicalDocument extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%post_clinical_documents}}', [
            'attachmentcontents' => $this->string(),
            'attachmenttype' => $this->string(),
            'autoclose' => $this->boolean(),
            'clinicalproviderid' => $this->integer(),
            'departmentid' => $this->integer()->notNull(),
            'documentdata' => $this->string(),
            'documentsubclass' => $this->string()->notNull(),
            'documenttypeid' => $this->integer(),
            'internalnote' => $this->string(),
            'observationdate' => $this->string(),
            'observationtime' => $this->string(),
            'priority' => $this->string(),
            'providerid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%post_clinical_documents}}');
    }
}
