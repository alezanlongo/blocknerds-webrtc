<?php

/**
 * Table for FamilyHistoryChanged
 */
class m211115_000000_070_FamilyHistoryChanged extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%family_history_changeds}}', [
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%family_history_changeds}}');
    }
}
