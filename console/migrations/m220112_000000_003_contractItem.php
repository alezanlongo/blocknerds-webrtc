<?php

/**
 * Table for contractItem
 */
class m220112_000000_003_contractItem extends \yii\db\Migration
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

    }

    public function down()
    {
        $this->dropTable('{{%contract_items}}');
    }
}
