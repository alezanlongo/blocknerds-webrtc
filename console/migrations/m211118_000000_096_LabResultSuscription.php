<?php

/**
 * Table for LabResultSuscription
 */
class m211118_000000_096_LabResultSuscription extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%lab_result_suscriptions}}', [
            'eventname' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%lab_result_suscriptions}}');
    }
}
