<?php

/**
 * Table for ListMedications
 */
class m211111_000000_071_ListMedications extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%list_medications}}', [
            'lastdownloaddenialreason' => $this->string(),
            'lastdownloaddenied' => $this->string(),
            'lastdownloadeddate' => $this->string(),
            'lastupdated' => $this->string(),
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
