<?php

/**
 * Table for BalanceItem
 */
class m210917_000000_BalanceItem extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%balance_items}}', [
            'balance' => $this->string(),
            'cleanbalance' => $this->string(),
            'collectionsbalance' => $this->string(),
            'contracts' => $this->string(),
            'departmentids' => $this->string(),
            'paymentplanbalance' => $this->string(),
            'providergroupid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%balance_items}}');
    }
}
