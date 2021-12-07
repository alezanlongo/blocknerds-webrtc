<?php

/**
 * Table for DosageQuantityUnit
 */
class m211206_000000_114_DosageQuantityUnit extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%dosage_quantity_units}}', [
            'quantityunit' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%dosage_quantity_units}}');
    }
}
