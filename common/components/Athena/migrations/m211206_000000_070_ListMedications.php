<?php

/**
 * Table for ListMedications
 */
class m211206_000000_070_ListMedications extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%list_medications}}', [
            'lastdownloaddenialreason' => $this->string(),
            'lastdownloaddenied' => $this->string(),
            'lastdownloadeddate' => $this->string(),
            'lastupdated' => $this->string(),
            'medications' => $this->string(),
            'nomedicationsreported' => $this->string(),
            'patientdownloadconsent' => $this->string(),
            'patientneedsdownloadconsent' => $this->string(),
            'sectionnote' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%list_medications}}');
    }
}
