<?php

/**
 * Table for ClinicalDocument200Response
 */
class m211202_000000_046_ClinicalDocument200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%clinical_document200_responses}}', [
            'clinicaldocumentid' => $this->integer(),
            'errormessage' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%clinical_document200_responses}}');
    }
}
