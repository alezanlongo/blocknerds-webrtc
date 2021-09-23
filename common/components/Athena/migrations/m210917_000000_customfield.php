<?php

/**
 * Table for customfield
 */
class m210917_000000_customfield extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%customfields}}', [
            'customfieldid' => $this->string(),
            'customfieldvalue' => $this->string(),
            'optionid' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%customfields}}');
    }
}
