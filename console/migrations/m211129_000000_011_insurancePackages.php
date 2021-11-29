<?php

/**
 * Table for insurancePackages
 */
class m211129_000000_011_insurancePackages extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%insurance_packages}}', [
            'addresslist' => $this->string(),
            'affiliations' => $this->string(),
            'insurancepackageid' => $this->integer(),
            'insuranceplanname' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%insurance_packages}}');
    }
}
