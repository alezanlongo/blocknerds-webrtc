<?php

/**
 * Table for OrderableDme
 */
class m211222_000000_133_OrderableDme extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%orderable_dmes}}', [
            'name' => $this->string(),
            'ordertypeid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%orderable_dmes}}');
    }
}
