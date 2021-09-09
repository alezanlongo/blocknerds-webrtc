<?php

/**
 * Table for BalanceItem
 */
class m210909_000000_BalanceItem extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%balance_items}}', [
            'balance' => text,
            'cleanbalance' => text,
            'collectionsbalance' => text,
            'contracts' => text,
            'departmentids' => text,
            'paymentplanbalance' => text,
            'providergroupid' => integer,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%balance_items}}');
    }
}
