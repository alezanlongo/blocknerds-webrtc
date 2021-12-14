<?php

/**
 * Table for LabResultSuscriptionSuccess
 */
class m211214_000000_096_LabResultSuscriptionSuccess extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%lab_result_suscription_successes}}', [
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%lab_result_suscription_successes}}');
    }
}
