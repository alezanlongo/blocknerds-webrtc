<?php

/**
 * Table for customfield
 */
class m211004_000000_005_customfield extends \yii\db\Migration
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

    }

    public function down()
    {
        $this->dropTable('{{%customfields}}');
    }
}
