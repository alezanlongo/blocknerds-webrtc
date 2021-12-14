<?php

/**
 * Table for PatientChanged
 */
class m211214_000000_026_PatientChanged extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%patient_changeds}}', [
            'totalcount' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%patient_changeds}}');
    }
}
