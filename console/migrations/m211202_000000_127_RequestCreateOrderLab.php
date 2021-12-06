<?php

/**
 * Table for RequestCreateOrderLab
 */
class m211202_000000_127_RequestCreateOrderLab extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_create_order_labs}}', [
            'diagnosissnomedcode' => $this->integer()->notNull(),
            'facilityid' => $this->integer(),
            'facilitynote' => $this->string(),
            'futuresubmitdate' => $this->string(),
            'highpriority' => $this->boolean(),
            'loinc' => $this->string(),
            'ordertypeid' => $this->integer(),
            'providernote' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_create_order_labs}}');
    }
}
