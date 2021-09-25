<?php

/**
 * Table for contractItem
 */
class m210925_000000_contractItem extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%contract_items}}', [
            'availablebalance' => $this->string(),
            'contractclass' => $this->string(),
            'maxamount' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%contract_items}}');
    }
}
