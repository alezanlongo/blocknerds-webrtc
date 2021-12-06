<?php

/**
 * Table for TotalQuantityUnit
 */
class m211206_000000_117_TotalQuantityUnit extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%total_quantity_units}}', [
            'quantityunit' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%total_quantity_units}}');
    }
}
