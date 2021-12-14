<?php

/**
 * Table for OrderableLab
 */
class m211214_000000_128_OrderableLab extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%orderable_labs}}', [
            'name' => $this->string(),
            'ordertypeid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%orderable_labs}}');
    }
}
