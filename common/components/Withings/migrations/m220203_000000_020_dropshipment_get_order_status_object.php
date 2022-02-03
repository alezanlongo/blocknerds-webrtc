<?php

/**
 * Table for dropshipment_get_order_status_object
 */
class m220203_000000_020_dropshipment_get_order_status_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_dropshipment_get_order_status_objects}}', [
            'order_id' => $this->string(),
            'customer_ref_id' => $this->string(),
            'status' => $this->string(),
            'carrier' => $this->string(),
            'carrier_service' => $this->string(),
            'tracking_number' => $this->string(),
            'parcel_status' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_dropshipment_get_order_status_objects}}');
    }
}
