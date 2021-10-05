<?php

/**
 * Table for BalanceItem
 */
class m211004_000000_004_BalanceItem extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%balance_items}}', [
            'balance' => $this->string(),
            'cleanbalance' => $this->string(),
            'collectionsbalance' => $this->string(),
            'departmentids' => $this->string(),
            'paymentplanbalance' => $this->string(),
            'providergroupid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%balance_items}}');
    }
}