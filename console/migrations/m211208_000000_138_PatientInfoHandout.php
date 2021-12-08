<?php

/**
 * Table for PatientInfoHandout
 */
class m211208_000000_138_PatientInfoHandout extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%patient_info_handouts}}', [
            'name' => $this->string(),
            'ordertypeid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%patient_info_handouts}}');
    }
}
