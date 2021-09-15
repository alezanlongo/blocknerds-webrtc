<?php

/**
 * Table for insurancePackages
 */
class m210909_000000_insurancePackages extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%insurance_packages}}', [
            'addresslist' => text,
            'affiliations' => text,
            'insurancepackageid' => integer,
            'insuranceplanname' => text,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%insurance_packages}}');
    }
}
