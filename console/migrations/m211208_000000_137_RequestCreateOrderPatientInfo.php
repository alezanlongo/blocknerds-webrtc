<?php

/**
 * Table for RequestCreateOrderPatientInfo
 */
class m211208_000000_137_RequestCreateOrderPatientInfo extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_create_order_patient_infos}}', [
            'diagnosissnomedcode' => $this->integer()->notNull(),
            'externalnote' => $this->string(),
            'ordertypeid' => $this->integer()->notNull(),
            'providernote' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_create_order_patient_infos}}');
    }
}
