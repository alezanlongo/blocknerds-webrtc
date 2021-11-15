<?php

/**
 * Table for PostLabResultSuscrioption
 */
class m211115_000000_083_PostLabResultSuscrioption extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%post_lab_result_suscrioptions}}', [
            'departmentids' => $this->string(),
            'eventname' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%post_lab_result_suscrioptions}}');
    }
}
