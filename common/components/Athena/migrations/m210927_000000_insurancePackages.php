<?php

/**
 * Table for insurancePackages
 */
class m210927_000000_insurancePackages extends \yii\db\Migration
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
