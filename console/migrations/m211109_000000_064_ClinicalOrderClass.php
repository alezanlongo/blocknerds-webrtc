<?php

/**
 * Table for ClinicalOrderClass
 */
class m211109_000000_064_ClinicalOrderClass extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%clinical_order_classes}}', [
            'clinicalorderclassid' => $this->float(),
            'name' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%clinical_order_classes}}');
    }
}
