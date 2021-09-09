<?php

/**
 * Table for contractItem
 */
class m210909_000000_contractItem extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%contract_items}}', [
            'availablebalance' => text,
            'contractclass' => text,
            'maxamount' => text,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%contract_items}}');
    }
}
