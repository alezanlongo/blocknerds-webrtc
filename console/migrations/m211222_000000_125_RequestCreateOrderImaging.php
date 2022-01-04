<?php

/**
 * Table for RequestCreateOrderImaging
 */
class m211222_000000_125_RequestCreateOrderImaging extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_create_order_imagings}}', [
            'diagnosissnomedcode' => $this->integer()->notNull(),
            'facilityid' => $this->integer(),
            'facilitynote' => $this->string(),
            'futuresubmitdate' => $this->string(),
            'highpriority' => $this->boolean(),
            'ordertypeid' => $this->integer()->notNull(),
            'providernote' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_create_order_imagings}}');
    }
}
