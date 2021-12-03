<?php

/**
 * Table for OrderableMedication
 */
class m211202_000000_116_OrderableMedication extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%orderable_medications}}', [
            'name' => $this->string(),
            'ordertypeid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%orderable_medications}}');
    }
}
