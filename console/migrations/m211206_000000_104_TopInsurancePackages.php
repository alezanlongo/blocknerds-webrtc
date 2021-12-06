<?php

/**
 * Table for TopInsurancePackages
 */
class m211206_000000_104_TopInsurancePackages extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%top_insurance_packages}}', [
            'address' => $this->string(),
            'address2' => $this->string(),
            'city' => $this->string(),
            'insurancepackageid' => $this->string(),
            'insuranceproducttypename' => $this->string(),
            'name' => $this->string(),
            'percentage' => $this->string(),
            'phone' => $this->string(),
            'ranking' => $this->string(),
            'state' => $this->string(),
            'zip' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%top_insurance_packages}}');
    }
}
