<?php

/**
 * Table for dropshipment_create_order_object
 */
class m220203_000000_019_dropshipment_create_order_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_dropshipment_create_order_objects}}', [
            'order_id' => $this->string(),
            'customer_ref_id' => $this->string(),
            'status' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_dropshipment_create_order_objects}}');
    }
}
