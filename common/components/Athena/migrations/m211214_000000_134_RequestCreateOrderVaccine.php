<?php

/**
 * Table for RequestCreateOrderVaccine
 */
class m211214_000000_134_RequestCreateOrderVaccine extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_create_order_vaccines}}', [
            'administernote' => $this->string(),
            'declineddate' => $this->string(),
            'declinedreason' => $this->integer(),
            'diagnosissnomedcode' => $this->integer()->notNull(),
            'dispenseaswritten' => $this->boolean(),
            'facilityid' => $this->string(),
            'ndc' => $this->string(),
            'numrefillsallowed' => $this->integer(),
            'orderingmode' => $this->string(),
            'ordertypeid' => $this->integer()->notNull(),
            'performondate' => $this->string(),
            'pharmacynote' => $this->string(),
            'providernote' => $this->string(),
            'totalquantity' => $this->float(),
            'totalquantityunit' => $this->string(),
            'unstructuredsig' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_create_order_vaccines}}');
    }
}
