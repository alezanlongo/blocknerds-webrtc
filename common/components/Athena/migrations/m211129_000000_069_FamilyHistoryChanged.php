<?php

/**
 * Table for FamilyHistoryChanged
 */
class m211129_000000_069_FamilyHistoryChanged extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%family_history_changeds}}', [
            'totalcount' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%family_history_changeds}}');
    }
}
