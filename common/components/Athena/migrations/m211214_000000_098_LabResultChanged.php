<?php

/**
 * Table for LabResultChanged
 */
class m211214_000000_098_LabResultChanged extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%lab_result_changeds}}', [
            'totalcount' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%lab_result_changeds}}');
    }
}
