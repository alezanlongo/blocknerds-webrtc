<?php

/**
 * Table for OtherOrderType
 */
class m211222_000000_142_OtherOrderType extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%other_order_types}}', [
            'name' => $this->string(),
            'ordertypeid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%other_order_types}}');
    }
}
