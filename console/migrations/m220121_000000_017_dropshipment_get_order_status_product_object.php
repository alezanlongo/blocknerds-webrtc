<?php

/**
 * Table for dropshipment_get_order_status_product_object
 */
class m220121_000000_017_dropshipment_get_order_status_product_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_dropshipment_get_order_status_product_objects}}', [
            'ean' => $this->string(),
            'quantity' => $this->integer(),
            'mac_addresses' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_dropshipment_get_order_status_product_objects}}');
    }
}
