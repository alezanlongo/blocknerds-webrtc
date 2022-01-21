<?php

/**
 * Table for dropshipment_create_order_product_object
 */
class m220121_000000_016_dropshipment_create_order_product_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_dropshipment_create_order_product_objects}}', [
            'ean' => $this->string(),
            'quantity' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_dropshipment_create_order_product_objects}}');
    }
}
