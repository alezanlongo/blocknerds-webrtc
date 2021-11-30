<?php

/**
 * Table for RequestCreateOrderPrescription
 */
class m211130_000000_107_RequestCreateOrderPrescription extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_create_order_prescriptions}}', [
            'additionalinstructions' => $this->string(),
            'administernote' => $this->string(),
            'diagnosissnomedcode' => $this->integer()->notNull(),
            'dispenseaswritten' => $this->boolean(),
            'dosagequantity' => $this->float(),
            'dosagequantityunit' => $this->string(),
            'duration' => $this->float(),
            'externalnote' => $this->string(),
            'facilityid' => $this->integer(),
            'frequency' => $this->string(),
            'ndc' => $this->string(),
            'numrefillsallowed' => $this->integer(),
            'orderingmode' => $this->string(),
            'ordertypeid' => $this->integer(),
            'pharmacyncpdpid' => $this->string(),
            'pharmacynote' => $this->string(),
            'providernote' => $this->string(),
            'rxnormid' => $this->string(),
            'totalquantity' => $this->float(),
            'totalquantityunit' => $this->string(),
            'unstructuredsig' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_create_order_prescriptions}}');
    }
}
