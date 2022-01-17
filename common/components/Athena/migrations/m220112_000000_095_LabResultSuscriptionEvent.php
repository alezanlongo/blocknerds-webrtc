<?php

/**
 * Table for LabResultSuscriptionEvent
 */
class m220112_000000_095_LabResultSuscriptionEvent extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%lab_result_suscription_events}}', [
            'status' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%lab_result_suscription_events}}');
    }
}
