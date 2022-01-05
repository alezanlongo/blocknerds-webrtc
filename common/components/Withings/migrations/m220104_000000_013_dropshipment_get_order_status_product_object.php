<?php

/**
 * Table for dropshipment_get_order_status_product_object
 */
class m220104_000000_013_dropshipment_get_order_status_product_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%dropshipment_get_order_status_product_objects}}', [
            'ean' => $this->string(),
            'quantity' => $this->integer(),
            'mac_addresses' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%dropshipment_get_order_status_product_objects}}');
    }
}
