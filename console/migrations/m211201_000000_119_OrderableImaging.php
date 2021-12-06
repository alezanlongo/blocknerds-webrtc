<?php

/**
 * Table for OrderableImaging
 */
class m211201_000000_119_OrderableImaging extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%orderable_imagings}}', [
            'name' => $this->string(),
            'ordertypeid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%orderable_imagings}}');
    }
}
