<?php

/**
 * Table for contractItem
 */
class m210916_000000_contractItem extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%contract_items}}', [
            'availablebalance' => $this->string(),
            'contractclass' => $this->string(),
            'maxamount' => $this->string(),
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
