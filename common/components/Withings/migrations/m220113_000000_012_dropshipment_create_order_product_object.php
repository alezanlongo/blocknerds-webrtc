<?php

/**
 * Table for dropshipment_create_order_product_object
 */
class m220113_000000_012_dropshipment_create_order_product_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%dropshipment_create_order_product_objects}}', [
            'ean' => $this->string(),
            'quantity' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%dropshipment_create_order_product_objects}}');
    }
}
