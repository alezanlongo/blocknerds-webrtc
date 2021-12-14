<?php

/**
 * Table for RequestCreateOrderOther
 */
class m211214_000000_141_RequestCreateOrderOther extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_create_order_others}}', [
            'diagnosissnomedcode' => $this->integer()->notNull(),
            'facilityid' => $this->integer(),
            'facilitynote' => $this->string(),
            'highpriority' => $this->boolean(),
            'ordertypeid' => $this->integer()->notNull(),
            'providernote' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_create_order_others}}');
    }
}
