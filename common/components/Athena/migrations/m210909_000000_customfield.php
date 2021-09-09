<?php

/**
 * Table for customfield
 */
class m210909_000000_customfield extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%customfields}}', [
            'customfieldid' => text,
            'customfieldvalue' => text,
            'optionid' => text,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%customfields}}');
    }
}
