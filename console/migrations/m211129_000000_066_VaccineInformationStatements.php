<?php

/**
 * Table for VaccineInformationStatements
 */
class m211129_000000_066_VaccineInformationStatements extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%vaccine_information_statements}}', [
            'clinicalorderclassid' => $this->float(),
            'dateonvis' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%vaccine_information_statements}}');
    }
}
