<?php

/**
 * Table for RequestCreateOrderReferral
 */
class m211214_000000_139_RequestCreateOrderReferral extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_create_order_referrals}}', [
            'diagnosissnomedcode' => $this->integer()->notNull(),
            'facilityid' => $this->integer(),
            'facilitynote' => $this->string(),
            'futuresubmitdate' => $this->string(),
            'highpriority' => $this->boolean(),
            'notetopatient' => $this->string(),
            'ordertypeid' => $this->integer()->notNull(),
            'procedurecode' => $this->string(),
            'providernote' => $this->string(),
            'reasonforreferral' => $this->string(),
            'startdate' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_create_order_referrals}}');
    }
}
