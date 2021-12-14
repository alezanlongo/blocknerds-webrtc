<?php

/**
 * Table for RequestCreateOrderDme
 */
class m211214_000000_132_RequestCreateOrderDme extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_create_order_dmes}}', [
            'diagnosissnomedcode' => $this->integer()->notNull(),
            'dispenseaswritten' => $this->boolean(),
            'facilityid' => $this->string(),
            'facilitynote' => $this->string(),
            'numrefillsallowed' => $this->integer(),
            'orderingmode' => $this->string(),
            'ordertypeid' => $this->integer()->notNull(),
            'providernote' => $this->string(),
            'totalquantity' => $this->float(),
            'unstructuredsig' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_create_order_dmes}}');
    }
}
