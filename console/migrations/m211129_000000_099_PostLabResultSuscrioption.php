<?php

/**
 * Table for PostLabResultSuscrioption
 */
class m211129_000000_099_PostLabResultSuscrioption extends \yii\db\Migration
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
